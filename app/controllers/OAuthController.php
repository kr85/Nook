<?php

use Nook\Users\UserRepository;
use AdamWathan\EloquentOAuth\Exceptions\ApplicationRejectedException;
use AdamWathan\EloquentOAuth\Exceptions\InvalidAuthorizationCodeException;

/**
 * Class OAuthController
 */
class OAuthController extends BaseController
{

    /**
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    /**
     * Constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Authorize a provider.
     *
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authorize($provider)
    {
        return OAuth::authorize($provider);
    }

    /**
     * Login for a provider.
     *
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login($provider)
    {
        try
        {
            OAuth::login($provider, function ($user, $userDetails)
            {
                $this->userRepository->findByEmailOrCreate($user, $userDetails);
            });
        }
        catch (ApplicationRejectedException $e)
        {
            Log::error($e);

            return Redirect::home();
        }
        catch (InvalidAuthorizationCodeException $e)
        {
            Log::error($e);

            return Redirect::home();
        }

        $user = Auth::user();

        return Redirect::intended();
    }
}