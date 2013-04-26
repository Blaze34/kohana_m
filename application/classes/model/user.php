<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User implements Acl_Role_Interface, Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'username' => Jelly::field('string', array(
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 3)),
					array('max_length', array(':value', 50))
				),
				'unique' => TRUE,
				'label' => 'user.field.username'
			)),
			'email' => Jelly::field('email', array(
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 3))
				),
				'unique' => TRUE,
				'label' => 'user.field.email'
			)),
			'password' => Jelly::field('password', array(
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 4))
				),
				'hash_with' => array(Auth_Jelly::instance(), 'hash'),
				'label' => 'user.field.password'
			)),
			'firstname' => Jelly::field('string', array(
				'rules' => array(
                    array('not_empty'),
                    array('max_length', array(':value', 250)),
				),
                'unique' => TRUE,
				'label' => 'user.field.firstname'
			)),

			'role' => Jelly::field('enum', array(
				'default' => 'login',
				'choices' => array('login', 'admin')
			)),

			'avatar' => Jelly::field('boolean', array(
				'default' => FALSE
			)),

			'hash' => Jelly::field('string'),

			// Relationships to other models
			'user_tokens' => Jelly::field('hasmany', array(
				'foreign' => 'user_token',
			)),

            'materials' => Jelly::field('hasmany', array())
		));
	}

	public function get_user($unique_key)
	{
		return Jelly::query('user')->where($this->unique_key($unique_key), '=', $unique_key)->limit(1)->select();
	}

	public function delete_tokens($user_id)
	{
		return Jelly::query('user', $user_id)->select()->get('user_tokens')->delete();
	}

    public function is_admin()
    {
        return ($this->role == 'admin');
    }

	public function fullName()
	{
		return UTF8::trim($this->lastname.' '.$this->firstname);
	}

    public function get_role_id()
    {
        return $this->role;
    }

    public function get_resource_id()
    {
        return 'user';
    }

	protected $is_me = NULL;

	public function is_me()
	{
		if ( ! $this->id())
			return FALSE;

		if ( $this->is_me === NULL)
		{
			$me = A2::instance()->get_user();
			$this->is_me = ($me && $me->id() && $me->id() == $this->id()) ? TRUE : FALSE;
		}

		if ($this->is_me !== NULL)
			return $this->is_me;
		return FALSE;
	}

	public static function get_password_validation($values)
	{
		return Validation::factory($values)
			->rule('password_confirm', 'min_length', array(':value', 4))
			->rule('password_confirm', 'matches', array(':validation', ':field', 'password'))
			->label('password_confirm', 'user.field.password_confirm')
			->label('password', 'user.field.password');
	}

	/**
	 * Update an existing user
	 *
	 * [!!] We make the assumption that if a user does not supply a password, that they do not wish to update their password.
	 *
	 * Example usage:
	 * ~~~
	 * $user = Jelly::factory('user', 1)
	 *	->update_user($_POST, array(
	 *		'username',
	 *		'password',
	 *		'email',
	 *	);
	 * ~~~
	 *
	 * @param array $values
	 * @param array $expected
	 * @throws Validation_Exception
	 */
	public function update_user($values, $expected)
	{
		$extra_validation = NULL;
		if (Arr::get($values, 'password') OR Arr::get($values, 'password_confirm'))
		{
			// Validation for passwords
			$expected[] = 'password';
			$expected[] = 'password_confirm';
			$extra_validation = Model_User::get_password_validation($values);
		}
		else
		{
			unset($values['password'], $values['password_confirm']);
		}



		return $this->set(Arr::extract($values, $expected))->save($extra_validation);
	}

    public function allowed($resource = NULL, $privilege = NULL)
    {
        return A2::instance()->is_allowed($this, $resource, $privilege);
    }

	public function avatar($_type = 'thumb', $path = TRUE)
	{
		$_config = Kohana::$config->load('user.avatar');

		if ( ! $this->avatar)
			return ($path ? '/' : '').$_config['dir'].$_config['default'];

		$_dir = $this->avatar_dir();

		return ($path ? '/' : '').$_dir.implode('.', array($_config['types'][$_type]['prefix'].hash($_config['hash'], $this->id().$_config['salt']).$_config['types'][$_type]['postfix'],$_config['as']));
	}

	public function avatar_dir()
	{
		if ( ! $this->id())
			return NULL;

		$_config = Kohana::$config->load('user.avatar');

		return $_config['dir'].floor($this->id()/$_config['split']).'/';
	}

	public function save_avatar($_tmp, $save = TRUE)
	{
		if ($this->id())
		{
			$_config = Kohana::$config->load('user.avatar');
			$_dir = $this->avatar_dir();

			$_valid = TRUE;

			$image = Image::factory($_dir.$_tmp);
			$image->render($_config['as']);

			foreach ($_config['types'] as $type)
			{
				$_do = $type['do'];
				if ($_do == 'crop')
				{
					$ratio = $type['width'] / $type['height'];
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
					$image->resize($type['width'], $type['height']);
				}
				elseif (($_do == 'resize') AND (($image->width > $type['width']) OR ($image->height > $type['height'])))
				{
					$image->$_do($type['width'], $type['height']);
				}
				$_valid = $image->save($_dir.implode('.', array($type['prefix'].hash($_config['hash'], $this->id().$_config['salt']).$type['postfix'],$_config['as'])), $type['quality']);
			}

			if ($_valid)
			{
				if ($save)
					$this->set('avatar', TRUE)->save();
				return TRUE;
			}
		}
		return FALSE;
	}

	public function rm_avatar($save = TRUE)
	{
		if ($this->id() AND $this->avatar)
		{
			$_config = Kohana::$config->load('user.avatar');
			$_dir = $this->avatar_dir();

			foreach ($_config['types'] as $type)
			{
				$_fn = $_dir.implode('.', array($type['prefix'].hash($_config['hash'], $this->id().$_config['salt']).$type['postfix'],$_config['as']));
				if (file_exists($_fn))
					unlink($_fn);
			}

			if ($save)
				$this->set('avatar', FALSE)->save();
		}

		return TRUE;
	}

	public function complete_login()
	{

	}
}