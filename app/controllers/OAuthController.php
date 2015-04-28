<?php

use AdamWathan\EloquentOAuth\Exceptions\ApplicationRejectedException;
use AdamWathan\EloquentOAuth\Exceptions\InvalidAuthorizationCodeException;

/**
 * Class OAuthController
 */
class OAuthController extends BaseController
{

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
                try
                {
                    dd($userDetails);
                    $user['username'] = $userDetails->nickname;
                    if (isset($userDetails->email))
                    {
                        $user['email'] = $userDetails->email;
                    }
                    else
                    {
                        $user['email'] = '';
                    }
                    if ($user->save())
                    {
                        Redirect::intended();
                    }
                    else
                    {
                        throw new Exception;
                    }
                }
                catch (Exception $e)
                {
                    Log::error($e);

                    return Redirect::home();
                }
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