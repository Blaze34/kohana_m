<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Tag extends Controller_Web {


    public function action_get()
    {
        if (Request::initial()->is_ajax() && ($t = mb_strtolower(Arr::get($_POST, 'term'))))
        {
            $data = array();
			$config = Tags::config();
			$exclude = Arr::get($_POST, 'exclude', array());
            $jb = Jelly::query('tag')->select_array(array('*', array(DB::expr('COUNT(*)'), 'c')))->join('materials_tags')->on('tag.id', '=', 'materials_tags.tag_id')->where('name','LIKE',$t.'%');
			if(is_array($exclude) AND sizeof($exclude))
			{
				$jb->and_where('name', 'NOT IN', $exclude);
			}
			$terms = $jb->group_by('tag_id')->order_by('c', 'DESC')->limit($config['tags_hint'])->execute();

			$before_match = $config['before_match'] ? $config['before_match'] : '<strong>';
			$after_match = $config['after_match'] ? $config['after_match'] : '</strong>';

            foreach($terms as $term)
            {
                $data[] = array(
                    'id' => $term->id(),
                    'value' => $term->name,
                );
            }
            $this->view('/clean')->echo = json_encode($data);
        }
        else
        {
            $this->redirect('/');
        }
    }

    public function action_show()
    {
        if(sizeof($tags = Arr::get($_GET, 'q')))
        {
            $materials = array();
            $tags_id = Jelly::query('tag')->select_column('id')->where('name', (is_array($tags) ? 'IN' : '='), Arr::get($_GET, 'q'))->select_all()->as_array('id', 'id');
            if ($tags_id)
            {
                $mids = Jelly::query('materials_tags')->where('tag_id', 'IN', $tags_id)->select_all()->as_array('material_id', 'material_id');

                if(sizeof($mids))
                {
                    $materials = Jelly::query('material')->where('id', 'IN', $mids)->pagination()->select_all();
                }

            }

            $this->view()->materials = $materials;
        }
        else
        {
            $this->redirect('/');
        }
    }
}