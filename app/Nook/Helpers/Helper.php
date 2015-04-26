<?php namespace Nook\Helpers;

use Auth;
use File;
use Config;

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
        return File::exists(public_path().'/media/profiles/'.$userFolder.'/statuses/'.$imageName);
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
}