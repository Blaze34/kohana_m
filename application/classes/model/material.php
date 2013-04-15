<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Material extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'title' => Jelly::field('string', array(
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 3)),
					array('max_length', array(':value', 250))
				),
				'label' => 'material.field.title'
			)),

			'category' => Jelly::field('belongsto', array(
				'rules' => array(
					array('not_zero'),
				),
				'label' => 'material.field.category'
			)),

			'description' => Jelly::field('text', array(
				'label' => 'material.field.description'
			)),

			'start' => Jelly::field('float', array(
				'default' => NULL
			)),
			'end' => Jelly::field('float', array(
				'default' => NULL
			)),

			'popular_index' => Jelly::field('integer', array(
				'default' => 0
			)),

            'popular_category' => Jelly::field('integer', array(
                'default' => 0
            )),

            'commented_category' => Jelly::field('integer', array(
                'default' => 0
            )),

            'novelty_index' => Jelly::field('integer', array(
                'default' => 0
            )),

			'user' => Jelly::field('belongsto', array(
				'label' => 'material.field.user'
			)),

			'video' => Jelly::field('string'),

			'file' => Jelly::field('string'),

			'url' => Jelly::field('string', array(
				'label' => 'material.field.url'
			)),

			'tags' => Jelly::field('manytomany'),

            'date' => Jelly::field('timestamp', array(
                'auto_now_create' => TRUE,
            )),

            'on_index' => Jelly::field('boolean', array(
                'default' => true,
                'label' => 'holder.field.activity',
            )),

            'comments' => Jelly::field('hasmany'),

            'likes' => Jelly::field('integer', array(
                'default' => 0
            )),
            'dislikes' => Jelly::field('integer', array(
                'default' => 0
            )),
            'views' => Jelly::field('integer', array(
                'default' => 0
            )),
            'days' => Jelly::field('integer', array(
                'default' => 0
            )),
            'comments_count' => Jelly::field('integer', array(
                'default' => 0
            ))
		));
	}

    public function get_resource_id()
    {
        return 'material';
    }

	public function dir($group)
	{
		if ( ! $this->id())
			return NULL;

		$_config = Kohana::$config->load('material.'.$group);

		return $_config['dir'].floor($this->id()/$_config['split']).'/';
	}

	public function thumb($with_default = TRUE)
	{
		$_config = Kohana::$config->load('material.thumb');

		$_dir = $this->dir('thumb');

		$thumb = $_dir.$this->get_filename('thumb');

		if (file_exists($thumb))
			return $thumb;

		return $with_default ? $_config['default'] : NULL;
	}

    public function file()
    {
        $_dir = $this->dir('gif');

        $thumb = $_dir.$this->file;

        if (file_exists($thumb))
            return $thumb;
    }

	public function get_filename($group)
	{
		$_config = Kohana::$config->load('material.'.$group);
		return implode('.', array(hash($_config['hash'], $this->id().$_config['salt']),$_config['as']));
	}

	public function save_thumb($_tmp)
	{
		if ($this->id())
		{
			$_config = Kohana::$config->load('material.thumb');
			$_dir = $this->dir('thumb');

			if ( ! is_dir($_dir))
			{
				mkdir($_dir);
			}

			$image = Image::factory($_tmp);
			$image->render($_config['as']);

			$ratio = $_config['width'] / $_config['height'];
			if ($image->width > $image->height)
			{
				// inscribing by height
				$_h = $image->height;
				$_w = round($image->height * $ratio); // calc width by height
				if ($_w > $image->width)
				{
					$_w = $image->width;
					$_h = round($_w / $ratio);
					$coords = array( 0, round(($image->height - $_h)/2) );
				}
				else
				{
					$coords = array( round(($image->width - $_w)/2), 0 );
				}
			}
			else
			{
				$_h = round($image->width / $ratio);
				$_w = $image->width;
				if ($_h > $image->height)
				{
					$_h = $image->height;
					$_w = round($_h * $ratio);
					$coords = array( round(($image->width - $_w)/2), 0 );
				}
				else
				{
					$coords = array( 0, round(($image->height - $_h)/2) );
				}
			}
			$image->crop($_w, $_h, $coords[0],$coords[1]);
			$image->resize($_config['width'], $_config['height']);

			$_valid = $image->save($_dir.$this->get_filename('thumb'), $_config['quality']);

			if ($_valid)
			{
				return TRUE;
			}
		}
		return FALSE;
	}

	public function rm_thumb()
	{
		if ($this->id())
		{
			$_config = Kohana::$config->load('material.thumb');
			$_dir = $this->dir('thumb');

			$_fn = $_dir.implode('.', array($_config['prefix'].hash($_config['hash'], $this->id().$_config['salt']).$_config['postfix'],$_config['as']));
				if (file_exists($_fn))
					unlink($_fn);
		}

		return TRUE;
	}


    public function increment($field)
    {
        $this->$field +=1;
        $this->save();
        $this->recount();
    }

    public function decrement($field)
    {
        $this->$field -=1;
        $this->save();
        $this->recount();
    }

    public function recount()
    {
        $formulas = Jelly::query('formula')->select_all();

        $l = $this->likes;
        $d = $this->dislikes;
        $this->days = $t = Date::span($this->date, time(), 'days');
        $c = $this->comments_count;
        $v = $this->views;

        $output = array();

        foreach($formulas as $f)
        {
            if(eval("\$rez = round($f->formula);") !== FALSE)
            {
                $output[$f->name] = (int)$rez;
            }
            else
            {
                $this->errors('Error in formula');
            }
        }

        foreach($output as $k => $v)
        {
            $this->$k = $v;
        }

        $model = $this->save();

        if($model->saved())
        {
            return true;
        }

        return false;


    }

    public function add_opinion($value)
    {
        if($value)
        {
            $this->increment('likes');
        }
        else
        {
            $this->increment('dislikes');
        }

        $this->recount();
    }

    public function update_opinion($value)
    {
        if($value)
        {
            $this->likes += 1;
            $this->dislikes -= 1;
        }
        else
        {
            $this->likes -= 1;
            $this->dislikes += 1;
        }

        $this->save();
        $this->recount();
    }

    public function total_recount()
    {

        $id = $this->id();
        $commets_count = Jelly::query('comment')->select_column (DB::expr ('COUNT(id)'), 'count')->where('material', '=', $id)->limit(1)->select();
        if($commets_count->count != $this->comments_count)
        {
            $this->comments_count = $commets_count->count;
        }

        $vote = Jelly::query('poll')
            ->select_column(array(array(DB::expr ('COUNT(id)'), 'count'), 'value'))
            ->where('type', '=', 'material')
            ->where('type_id', '=', $id)
            ->group_by('value')->select_all()->as_array('value', 'count');

        list($dislikes, $likes) = $vote;

        if($this->likes != $likes)
        {
            $this->likes = $likes;
        }

        if($this->dislikes != $dislikes)
        {
            $this->dislikes = $dislikes;
        }

        $model = self::recount();

        if($model)
        {
            return true;
        }

        return false;
    }

}