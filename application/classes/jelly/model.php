<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Model extends Jelly_Core_Model
{
    /**
     * Returns data from original data set
     * @param  $key in original data set
     * @return mixed data by key
     */
    public function __original($key)
    {
        if ($key)
            return Arr::get($this->_original, $key);
        return NULL;
    }

    public function _enum($field, $value) {
        return ($value && in_array($value, $this->meta()->fields($field)->choices)) ? $value : $this->meta()->fields($field)->default;
    }
}
