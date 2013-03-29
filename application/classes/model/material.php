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
					array('not_empty'),
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

			'rating' => Jelly::field('integer', array(
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
                'auto_now_update' => TRUE
            )),
            'comments' => Jelly::field('hasmany'),
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
}