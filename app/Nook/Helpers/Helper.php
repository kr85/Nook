<?php namespace Nook\Helpers;

use Auth;
use File;
use Image;
use Config;
use Exception;
use Nook\Users\UserRepository as User;

/**
 * Class Helper
 *
 * @package Nook\Helpers
 */
class Helper
{

    /**
     * Get the path to the status media
     *
     * @param $imageName
     * @return string
     */
    public static function getStatusMediaPath($imageName)
    {
        return public_path().'/media/profiles/'.Auth::user()->username.'/statuses/'.$imageName;
    }

    /**
     * Get a file mime type by file extension.
     *
     * @param $extension
     * @param string $default
     * @return string
     */
    public static function mime($extension, $default = 'application/octet-stream')
    {
        $mimes = Config::get('mimes');

        if ( ! array_key_exists($extension, $mimes)) return $default;

        return (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
    }

    /**
     * Get a valid image.
     *
     * @param $file
     * @return array
     */
    public static function getValidImage($file)
    {
        $isValid = [];
        $isValid['success'] = true;

        if (
            self::mime($file['image']->getClientOriginalExtension()) != 'image/jpeg' &&
            self::mime($file['image']->getClientOriginalExtension()) != 'image/gif' &&
            self::mime($file['image']->getClientOriginalExtension()) != 'image/png' &&
            self::mime($file['image']->getClientOriginalExtension()) != 'image/bmp'
        )
        {
            $isValid['success'] = false;
            $isValid['message'] = "Your image's type is not supported.";
            dd(self::mime($file['image']->getClientOriginalExtension()));
            return $isValid;
        }

        if ($file['image']->getSize() > 20000000)
        {
            $isValid['success'] = false;
            $isValid['message'] = "Your image's size is greater than the maximum (20 MB).";

            return $isValid;
        }

        return $isValid;
    }

    /**
     * Check if a status image exists.
     *
     * @param $userFolder
     * @param $imageName
     * @return bool
     */
    public static function statusImageExist($userFolder, $imageName)
    {
        return File::exists(self::getStatusImageFolderAbsPath($userFolder).'/'.$imageName);
    }

    /**
     * Get the height of a status image.
     *
     * @param $userFolder
     * @param $imageName
     * @return int
     */
    public static function getStatusImageHeight($userFolder, $imageName)
    {
        return Image::make(public_path().'/'.self::getStatusImagePath($userFolder, $imageName))->height();
    }

    /**
     * Get the width of a status image.
     *
     * @param $userFolder
     * @param $imageName
     * @return int
     */
    public static function getStatusImageWidth($userFolder, $imageName)
    {
        return Image::make(public_path().'/'.self::getStatusImagePath($userFolder, $imageName))->width();
    }

    /**
     * Get the absolute path of user's status images folder.
     *
     * @param $userFolder
     * @return string
     */
    private static function getStatusImageFolderAbsPath($userFolder)
    {
        return public_path().'/media/profiles/'.$userFolder.'/statuses';
    }

    /**
     * Get a status image file.
     *
     * @param $userFolder
     * @param $imageName
     * @return string
     */
    public static function getStatusImage($userFolder, $imageName)
    {
        return File::get(self::getStatusImageFolderAbsPath($userFolder).'/'.$imageName);
    }

    /**
     * Get the path of a status image.
     *
     * @param $userFolder
     * @param $imageName
     * @return string
     */
    public static function getStatusImagePath($userFolder, $imageName)
    {
        return 'media/profiles/'.$userFolder.'/statuses/'.$imageName;
    }

    /**
     * Check if a url is valid.
     *
     * @param $url
     * @return bool
     */
    public static function isUrlValid($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false)
        {
            return false;
        }

        return true;
    }

    /**
     * Get a url from a string.
     *
     * @param $string
     * @return array
     */
    public static function getUrlFromString($string)
    {
        $array = explode(" ", $string);
        $result = [];
        $result['url'] = null;
        $result['text'] = null;

        foreach ($array as $a)
        {
            if (strpos($a, "http://") !== false || strpos($a, "https://") !== false)
            {
                $result['url'] = $a;
            }
            else
            {
                $result['text'][] = $a;
            }
        }

        return $result;
    }

    /**
     * Create a link to user's profile if found in the status or comment text.
     *
     * @param $string
     * @return array
     */
    private static function textManipulationToGetUserProfiles($string)
    {
        $array = explode(" ", $string);
        $result = [];

        foreach ($array as $a)
        {
            $word = null;
            if (strpos($a, "@") !== false)
            {
                if (self::isUrlValid(url($a)) && User::getByUsername(str_replace('@', '', $a)))
                {
                    $word = '<a href="'.$a.'">'.$a.'</a>';
                }
                else
                {
                    $word = $a;
                }
            }
            else
            {
                $word = $a;
            }
            $result[] = $word;
        }

        return $result;
    }

    /**
     * Get the modified comment.
     *
     * @param $comment
     * @return string
     */
    public static function getComment($comment)
    {
        return implode(' ', self::textManipulationToGetUserProfiles($comment));
    }

    /**
     * Get the modified status.
     *
     * @param $status
     * @return string
     */
    public static function getStatus($status)
    {
        return implode(' ', self::textManipulationToGetUserProfiles($status));
    }

    /**
     * Handle image manipulation for a image object.
     *
     * @param $image
     * @param $imageWidth
     * @return array
     * @throws Exception
     */
    public static function imageManipulationObj($image, $imageWidth)
    {
        // Result array
        $result = [];

        // Create image's name
        $fileName = str_random(12).'.jpg';

        // Get path to the image's folder
        $path = self::getStatusImageFolderAbsPath(Auth::user()->username);

        try
        {
            // Move the original image to the folder
            $image->move($path, $fileName);

            // Image manipulation
            // Create a new image
            $statusImage = Image::make($path.'/'.$fileName);

            // Resize the new image
            $statusImage->resize($imageWidth, null, function ($constraint)
            {
                $constraint->aspectRatio();
            });

            // Encode the image
            $statusImage->encode('jpg', 100);

            // Delete the original image
            unlink($path.'/'.$fileName);

            // Save the new image
            $statusImage->save($path.'/'.$fileName);

            $result['fileName'] = $fileName;
            $result['path'] = $path;
        }
        catch (Exception $e)
        {
            // Delete the original image
            unlink($path.'/'.$fileName);
            $result['errorMessage'] = 'The image could not be uploaded. Please refresh the page and try again.';
        }

        return $result;
    }

    /**
     * Handle image manipulation for a image from a url.
     *
     * @param $url
     * @param $imageWidth
     * @return array
     * @throws Exception
     */
    public static function imageManipulationUrl($url, $imageWidth)
    {
        $result = [];

        try
        {
            // Create new image's name
            $fileName = str_random(12).'.jpg';

            // Get path to the image's folder
            $path = self::getStatusImageFolderAbsPath(Auth::user()->username);

            // Check if the url is an image
            $image = getimagesize($url);
            if (is_array($image))
            {
                $statusImage = Image::make($url);

                // Resize the new image
                $statusImage->resize($imageWidth, null, function ($constraint)
                {
                    $constraint->aspectRatio();
                });

                // Encode the image
                $statusImage->encode('jpg', 100);

                // Save the new image
                $statusImage->save($path.'/'.$fileName);

                $result['path'] = $path;
                $result['fileName'] = $fileName;
            }
            else
            {
                $result['errorMessage'] = 'The url is not an image.';
            }
        }
        catch (Exception $e)
        {
            throw $e;
        }

        return $result;
    }
}