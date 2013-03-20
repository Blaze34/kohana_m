<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Tag extends Controller_Web {


    public function action_get()
    {
        if (Request::initial()->is_ajax() && ($t = Arr::get($_POST, 'term')))
        {
            $data = array();
			$config = Tags::config();
			$exclude = Arr::get($_POST, 'exclude', array());
            $jb = Jelly::query('tag')->select_array(array('*', array(DB::expr('COUNT(*)'), 'c')))->join('material_tags')->on('tag.id', '=', 'material_tags.tag_id')->where('name','LIKE',$t.'%');
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
                    'label' => preg_replace("/\b$t/iu", $before_match.$t.$after_match, $term->name),
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
}