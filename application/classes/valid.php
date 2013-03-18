<?php defined('SYSPATH') or die('No direct script access.');

class Valid extends Kohana_Valid {

    public static function not_zero($str)
	{
        return (is_int($str) AND $str > 0);
	}
}