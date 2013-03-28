<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sergey
 * Date: 3/28/13
 * Time: 12:01 PM
 * To change this template use File | Settings | File Templates.
 */

class Holder {

    /**
     * @param int $id
     * @param array $attr
     */

    public static function show(integer $id, array $attr = array())
    {
        $holder = Jelly::factory('holder', $id);
        if($holder->loaded())
        {
            if($holder->activity)
            {
                $output = array('body' => $holder->body);
                if(sizeof($attr))
                {
                    foreach ($attr as $k => $a)
                    {
                        if($k == 'style')
                        {
                            foreach ($a as $key => $i)
                            {
                                $output[$k] .= $key.': '.$i.'; ';
                            }
                        }
                        else
                        {
                            $output[$k] = $a;
                        }
                    }
                }
                echo View::factory('holder/show')->set('holder', $output)->render();
            }
        }
    }

}