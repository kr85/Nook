<?php namespace Nook\Statuses;

use Nook\Helpers\Helper;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

/**
 * Class PublishStatusCommandHandler
 *
 * @package Nook\Statuses
 */
class PublishStatusCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * Constructor.
     *
     * @param StatusRepository $statusRepository
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * Handle the command.
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        // Image file name
        $fileName = (string) null;
        // Store the status image
        $image = $command->image;
        // Image width
        $imageWidth = $command->imageWidth;
        // Store the status text
        $text = trim($command->body);
        // Error message
        $errorMessage = (string) null;
        // Result
        $result = [];

        if ($image)
        {
            // Handle image manipulation
            $array = Helper::imageManipulationObj($image, $imageWidth);

            if (!isset($array['errorMessage']))
            {
                // Get the new image's name
                $fileName = $array['fileName'];
            }
            else
            {
                $errorMessage = $array['errorMessage'];
            }
        }
        else
        {
            // Get the url from a string
            $arrayStringUrl = Helper::getUrlFromString($text);

            // Check if a url exists
            if ($arrayStringUrl['url'])
            {
                // Handle image manipulation
                $arrayImage = Helper::imageManipulationUrl($arrayStringUrl['url'], $imageWidth);

                if (!isset($arrayImage['errorMessage']))
                {
                    // Get the new image's name
                    $fileName = $arrayImage['fileName'];

                    // Handle status text
                    if ($arrayStringUrl['text'])
                    {
                        $text = implode(" ", $arrayStringUrl['text']);
                    }
                    else
                    {
                        $text = (string) null;
                    }
                }
                else
                {
                    $errorMessage = $arrayImage['errorMessage'];
                }
            }
            else
            {
                $fileName = (string) null;

                // Handle status text
                if ($arrayStringUrl['text'])
                {
                    $text = implode(" ", $arrayStringUrl['text']);
                }
            }
        }

        // Check if an error message has been set
        if ($errorMessage != '')
        {
            $result['message'] = $errorMessage;
            return $result;
        }

        // Setup the status and fires an event
        $status = Status::publish($text, $fileName);

        // Persists the status
        $status = $this->statusRepository->save($status, $command->user_id);

        // Dispatch an event
        $this->dispatchEventsFor($status);

        $result['status'] = $status;

        return $result;
    }
}