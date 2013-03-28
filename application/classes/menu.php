<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sergey
 * Date: 3/28/13
 * Time: 12:01 PM
 * To change this template use File | Settings | File Templates.
 */

class Menu {

    public static function show($id)
    {
        $menu = Jelly::factory('menu', $id);
        if($menu->loaded())
        {
            $menu_links = $menu->get('links')->order_by('sort')->select_all();
            if(sizeof($menu_links))
            {
                 echo View::factory('menu/show')->set('links', $menu_links)->render();
            }
        }
    }

}