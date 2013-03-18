<?php defined('SYSPATH') or die('No direct script access.');

abstract class Obj_Core {

    public static function get_user_id()
    {
        $instance = new ReflectionMethod(Kohana::config('obj.user'),'instance');
        $instance = $instance->invokeArgs(NULL, array());
        return ( ($instance AND $instance->get_user()) ? $instance->get_user()->id() : NULL);
    }

    protected static $objects = array();
    
    /**
     * Returns feed object
     */
    public static function get($model, $key = NULL, $owner = NULL, $auto_create = TRUE)
    {
        if ($model)
        {
            if ($model instanceof Model_Obj)
                return $model;

            if ($model instanceof Jelly_Model)
            {
             /*   if ($model->__isset('obj') AND $model->obj instanceof Jelly_Model AND $model->obj->loaded())
                    return $model->obj;
*/
                if ($key AND is_bool($key))
                {
                    $auto_create = $key;
                }
                $table = method_exists($model, 'get_resource_id') ? $model->get_resource_id() : NULL;
                $key = method_exists($model, 'id') ? $model->id() : NULL;
                $owner = ( isset($model->user) AND method_exists($model->user, 'id') ) ? $model->user->id() : NULL;
            }
            elseif (is_string($model))
            {
                $table = $model;
            }
            
            if ($table AND $key)
            {
                if ($instance = Arr::get(self::$objects, $table.':'.$key))
                {
                    return $instance;
                }

                $object = Jelly::select('obj')->where('table', '=', $table)->and_where('key', '=', $key)->load();

                if ($object->loaded())
                {
                    return self::$objects[$table.':'.$key] = $object;
                }
                else
                {
                    if ($auto_create)
                    {
                        $object = Jelly::factory('obj')->set(array(
                            'table' => $table, 'key' => $key, 'owner' => $owner,
                        ))->save();

                        if ($object->saved())
                            return self::$objects[$table.':'.$key] = $object;

                    }
                }
            }
        }
        return NULL;
    }

    /**
     * Deprecated
     * @static
     * @param  $model
     * @param  $key
     * @return void
     */

    public static function delete($model, $key = NULL)
    {
        if ($obj = self::get($model, $key, NULL, FALSE))
        {
            Attachment::delete($obj);
            unset(self::$objects[$obj->table.':'.$obj->key]);
            $obj->delete();
        }
    }

    public static function cache($module, $model, $data = array(), $key = NULL)
    {
        if ($module)
        {
            $obj = self::get($model, $key);
            if (is_array($data) AND (sizeof($data) == 0))
            {
                return Arr::get($obj->cache, $module);
            }
            elseif ( ! isset($obj->cache[$module]) OR $obj->cache[$module] != $data)
            {
                $cache = $obj->cache;
                $cache[$module] = $data;
                $obj->set('cache', $cache);
                try
                {
                    $obj->save();
                }
                catch (Database_Exception $e)
                {
                }
            }
        }
        return NULL;
    }
}
