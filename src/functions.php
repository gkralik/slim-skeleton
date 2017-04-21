<?php

if (!function_exists('env')) {
    /**
     * Get environment variable or default if not set.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    function env($key, $default = null)
    {
        $v = getenv($key);

        return $v !== false ? $v : $default;
    }
}

if (!function_exists('get_app_environment')) {
    /**
     * Get current application environment.
     *
     * Reads the APP_ENVIRONMENT env variable. If the env var is not set,
     * returns 'production' as default value.
     *
     * @return string Current application environment.
     */
    function get_app_environment()
    {
        return env('APP_ENVIRONMENT', 'production');
    }
}

if (!function_exists('current_ip')) {
    /**
     * Returns the current request's IP address.
     *
     * If the request is forwarded, the forwarded IP address is returned. If the function is called from CLI context,
     * an empty string is returned.
     *
     * @return string IP address.
     */
    function current_ip()
    {
        if (php_sapi_name() == 'cli') {
            return "";
        }

        return !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }
}