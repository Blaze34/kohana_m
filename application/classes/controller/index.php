<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Web {

	public function action_index()
	{
        list($polls, $comments, $materials) = $this->get_popular ();

        $this->view()->materials = $materials;
        $this->view()->comments = $comments;
        $this->view()->polls = $polls;
	}

    /**
     * @return array
     */
    protected function get_popular ()
    {
        $comments = $polls = array();

        $materials = Jelly::query ('material')->pagination ('popular')->select_all ();

        $mids = array();

        foreach ($materials as $m)
        {
            $mids[] = $m->id ();
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

        return array($polls, $comments, $materials);
    }
} // End Welcome
