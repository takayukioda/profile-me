<?php

class Session
{
    protected static $id = null;

    public static function start ()
    {
        session_cache_limiter(false);
        session_start();
        static::$id = session_id();
    }

    public static function regenerate ($deleteOldSession = false)
    {
        session_regenerate_id($deleteOldSession);
        static::$id = session_id();
    }

    public static function destroy ()
    {
        $_SESSION = array();
        session_destroy();
        static::$id = null;
    }

    public static function write ($key, $value = null)
    {
        if ($value === null) $value = true;
        $_SESSION[$key] = $value;
    }

    public static function read ($key, $default = null)
    {
        if (! static::check($key)) return $default;
        return $_SESSION[$key];
    }

    public static function check ($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function delete ($key)
    {
        if (static::check($key)) unset($_SESSION[$key]);
    }

    public static function id ()
    {
        return static::$id;
    }

    public static function setFlash ($key, $value = null)
    {
        if ($key === null) return false;
        if (! isset($_SESSION['flash'])) $_SESSION['flash'] = array();

        // use as flag
        if ($value === null) $value = true;

        $_SESSION['flash'][$key] = $value;
        return true;
    }

    public static function getFlash ($key, $default = null)
    {
        if ($key === null) return false;
        if (! isset($_SESSION['flash'])) {
            $_SESSION['flash'] = array();
            return $default;
        }

        $return = $default;
        if (isset($_SESSION['flash'][$key])) {
            $return = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
        }
        return $return;
    }
}
