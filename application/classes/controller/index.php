<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Web {

	public function action_index()
	{
        $_popular = $this->get_popular ();
        $_novelty = $this->get_novelty();

        $this->view(array('_popular' => $_popular, '_novelty' => $_novelty));
	}

    /**
     * @return array
     */
    protected function get_popular ()
    {
        $comments = $polls = array();

        $materials = Jelly::query ('material')->where('on_index', '=', 1)->order_by('popular_index', 'DESC')->limit(16)->select_all();

        $mids = array();

        foreach ($materials as $m)
        {
            $mids[] = $m->id();
        }

        if ($materials)
        {
            $comments = Jelly::query ('comment')
                ->with ('material')
                ->select_column (array(array(DB::expr ('COUNT(comments.id)'), 'count')))
                ->group_by ('material_id')
                ->select_all ()->as_array ('material');

            if (sizeof ($comments))
            {
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
        }

        return array('polls' => $polls, 'comments' =>  $comments, 'materials' => $materials);
    }

    protected function get_novelty ()
    {
        $comments = $polls = array();

        $materials = Jelly::query ('material')->where('on_index', '=', 1)->order_by('novelty_index', 'DESC')->order_by('date', 'DESC')->limit(16)->select_all();

        $mids = array();

        foreach ($materials as $m)
        {
            $mids[] = $m->id();
        }

        if ($materials)
        {
            $comments = Jelly::query ('comment')
                ->with ('material')
                ->select_column (array(array(DB::expr ('COUNT(comments.id)'), 'count')))
                ->group_by ('material_id')
                ->select_all ()->as_array ('material');

            if (sizeof ($comments))
            {
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
        }

        return array('polls' => $polls, 'comments' =>  $comments, 'materials' => $materials);
    }
} // End Welcome
