<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sergey
 * Date: 4/25/13
 * Time: 11:47 AM
 * To change this template use File | Settings | File Templates.
 */

class Admin
{
    public static $settings = array();

    public static function settings($key = NULL)
    {
        if ( ! sizeof(self::$settings))
        {
            self::$settings = Jelly::query('setting')->select_all();
        }

        if($key)
        {
            foreach (self::$settings as $s)
            {
                if ($s->title == $key)
                {
                    return $s->status;
                }
            }

            return NULL;
        }

        return self::$settings;
    }
}