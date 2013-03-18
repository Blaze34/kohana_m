<?php defined('SYSPATH') or die('No direct script access.');
class Model_Builder_Static extends Jelly_Builder
{
    public function with_body($lang = NULL)
    {
        if ( ! $lang) $lang = I18n::$lang;
        return $this->select_array(array('*', array('_static_body:body.id', ':body:id'), array('_static_body:body.lang', ':body:lang'), array('_static_body:body.title', ':body:title'), array('_static_body:body.text', ':body:text'), array('_static_body:body.static_id', ':body:static')))
                ->join(array('static_bodies', '_static_body:body'), 'LEFT')
                ->on(':primary_key', '=', '_static_body:body.static_id')
                ->on('_static_body:body.lang', '=', DB::expr('\''.$lang.'\''));
    }
}