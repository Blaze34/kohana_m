<?php defined('SYSPATH') or die('No direct script access.');

class Model_Obj extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
            'id' => new Field_Primary,
            'key' => new Field_Integer(array(
                'column' => 'object_id',
                'rules' => array(
                    'not_empty' => NULL
                )
            )),
            'table' => new Field_String(array(
                'column' => 'object_table',
                'rules' => array(
                    'not_empty' => NULL
                )
            )),
            'owner' => new Field_BelongsTo(array(
                'column' => 'user_id',
                'foreign' => 'user'
            )),
            'cache' => new Field_Json,
			'opinions' => new Field_HasMany,
        ));
    }


    public function cache($module, $data = array())
    {
        if ($module)
        {
            $cache_all = $this->get('cache') ? $this->get('cache') : array();
            if (is_array($data) AND (sizeof($data) == 0))
            {
                return Arr::get($cache_all, $module, array());
            }
            elseif ( ! isset($cache_all[$module]) OR $cache_all[$module] != $data)
            {
                $cache_all[$module] = $data;
                $this->set('cache', $cache_all);
                try
                {
                    $this->save();
                }
                catch (Database_Exception $e)
                {
                }
            }
        }
        return NULL;
    }

}
