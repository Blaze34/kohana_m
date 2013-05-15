<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Web {

	public function action_index()
	{

        $_popular = $this->get_popular ();
        $_novelty = $this->get_novelty();

        $setting = Jelly::query('setting')->select_all()->as_array('title');

        $this->meta(
            ($setting['index_meta_title']['status'] ? $setting['index_meta_title']['value'] : ''),
            ($setting['index_meta_desc']['status'] ? $setting['index_meta_desc']['value'] : '')
            );

        $this->view(array('_popular' => $_popular, '_novelty' => $_novelty));
	}

    /**
     * @return array
     */
    protected function get_popular ()
    {
        $comments = $polls = array();

        $materials = Jelly::query ('material')->where('on_index', '=', 1)->order_by('popular_index', 'DESC')->limit(16)->select_all();

        $mids = $materials->as_array('id', 'id');


        if (sizeof($materials))
        {
            $comments = Jelly::query ('comment')
                ->with ('material')
                ->select_column (array(array(DB::expr ('COUNT(comments.id)'), 'count')))
                ->group_by ('material_id')
                ->select_all ()->as_array ('material');

            $polls_arr = Jelly::query ('poll')
                ->select_column (array(array(DB::expr ('COUNT(id)'), 'count'), 'type_id', 'value'))
                ->where ('type', '=', Jelly::factory ('material')->get_resource_id ())
                ->where ('type_id', 'IN', $mids)
                ->group_by ('type_id', 'value')
                ->select_all ()->as_array ();

            if (sizeof ($polls_arr))
            {
                foreach ($polls_arr as $item)
                {
                    if ($item['value'])
                    {
                        $polls[$item['type_id']]['like'] = $item['count'];
                    }
                    else
                    {
                        $polls[$item['type_id']]['dislike'] = $item['count'];
                    }
                }
            }
        }

        return array('polls' => $polls, 'comments' =>  $comments, 'materials' => $materials);
    }

    protected function get_novelty ()
    {
        $comments = $polls = array();

        $materials = Jelly::query ('material')->where('on_index', '=', 1)->order_by('novelty_index', 'ASC')->order_by('date', 'DESC')->limit(16)->select_all();

        $mids = array();

        foreach ($materials as $m)
        {
            $mids[] = $m->id();
        }

        if (sizeof($materials))
        {
            $comments = Jelly::query ('comment')
                ->with ('material')
                ->select_column (array(array(DB::expr ('COUNT(comments.id)'), 'count')))
                ->group_by ('material_id')
                ->select_all ()->as_array ('material');

            $polls_arr = Jelly::query ('poll')
                ->select_column (array(array(DB::expr ('COUNT(id)'), 'count'), 'type_id', 'value'))
                ->where ('type', '=', Jelly::factory ('material')->get_resource_id ())
                ->where ('type_id', 'IN', $mids)
                ->group_by ('type_id', 'value')
                ->select_all ()->as_array ();


            if (sizeof ($polls_arr))
            {
                foreach ($polls_arr as $item)
                {
                    if ($item['value'])
                    {
                        $polls[$item['type_id']]['like'] = $item['count'];
                    }
                    else
                    {
                        $polls[$item['type_id']]['dislike'] = $item['count'];
                    }
                }
            }
        }

        return array('polls' => $polls, 'comments' =>  $comments, 'materials' => $materials);
    }

    public function action_search()
    {
        if($_POST)
        {
            $words = strtolower(addslashes(Arr::get($_POST, 'words')));

            $result = Jelly::query('material')->where(DB::expr('MATCH(title, description)'), '', DB::expr('AGAINST(\''.$words.'\'  IN BOOLEAN MODE)'))->select_all();

            $this->view()->result = $result;
        }
    }

    public function action_diff()
    {
        $values = Jelly::query('material')->select_column(array('id', 'category_id'))->select_all()->as_array('id', 'category_id');

//        echo Debug::vars($values);

        foreach ($values as $mid => $cid)
        {
//            echo Debug::vars(DB::insert('categories_materials', array('material_id', 'category_id'))->values( array($mid, $cid) ));

            $str []= '('.$mid.', '.$cid.')';
        }
//        echo ("INSERT INTO categories_materials (material_id, category_id) VALUES ".implode(', ', $str));
    }


} // End Welcome
