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

    public static function mask_title($str = '', $control_mask = array())
    {
        if(strlen((string) $str))
        {
            if(sizeof($control_mask))
            {
                foreach($control_mask as $m => $v)
                {
                    $str = str_replace($m, $v, $str);
                }

                return $str;
            }

            return $str;
        }

        return false;
    }

    public static function set_meta($model)
    {

        $meta_title = $model->meta_title;

        if(! $meta_title)
        {
            $type_model = $model->get_resource_id();

            switch ($type_model)
            {
                case ('category'):

                    $meta_title = $model->mask_title;

                    if( ! $meta_title AND $model->parent_id)
                    {
                        $category = Jelly::factory('category', $model->parent_id);

                        if($category->meta_title)
                        {
                            $meta_title = $category->mask_title;

                        }
                        elseif($category->mask_title)
                        {
                            $meta_title = $category->mask_title;
                        }
                    }

                    break;

                case ('material'):

                    $parents = Jelly::query('category')->where('parent_id', '=', 0)->select_all()->as_array('id');

                    foreach($model->categories as $c)
                    {
                        $meta_title = $c->mask_title;

                        if( ! $c->mask_title AND $c->parent_id)
                        {
                            $parent = Arr::get($parents, $c->parent_id);

                            if($parent['mask_title'])
                            {
                                $meta_title = $parent['mask_title'];
                                break;
                            }

                        }
                    }

                    break;
            }
        }

        $h1 = $model->title;

        $title = $model->title;

        if($meta_title)
        {
            $title = self::mask_title($meta_title, array('%h1%' => $h1));
        }


        $title = ($title ? $title : __('global.title'));

        $desc = ($model->meta_desc ? $model->meta_desc : NULL);

        return array('title' => $title, 'description' => $desc);
    }




}