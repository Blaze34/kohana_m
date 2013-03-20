<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Web {

	public function before()
	{
		if (in_array($this->request->action(), array('login', 'register', 'recover')))
		{
			$this->layout = 'auth';
		}
        elseif($this->request->action() == 'index')
        {
            $this->layout = 'admin';
        }
		return parent::before();
	}

	public function action_index()
	{
		if ($this->allowed())
		{
			$user = Jelly::query('user');
			$filters = Kohana::$config->load('user.filter');

			foreach ($filters as $name => $param)
			{
				if ($val = trim(Arr::get($_GET, $name)))
				{
					$val = $val.Arr::get($param, 'suffix', '');
					$user->where($name, Arr::get($param, 'condition', '='), $val);
				}
			}

			$user = $user->order_by('id', 'ASC')->pagination('list')->select();

			$this->view()->users = $user;
		}
		else
		{
			$this->redirect(Route::url('user', array('action' => 'edit')));
		}
	}

	public function action_register()
	{
		$this->title('user.register');
		if ( ! $this->user)
		{
			if ($_POST)
			{
				$field_list = array(
					'username',
					'password',
					'password_confirm',
					'email',
					'firstname',
					'lastname',
					'birthday',
					'whatdo',
					'mobile',
					'model',
					'city',
					'pay',
					'ym_purse',
					'wm_purse',
					'qiwi_purse',
					'vk_page',
					'operator_name',
					'card_number',
					'expiration_mon',
					'expiration_year',
				);
				$post = $_POST;
				if ( ! array_key_exists('birthday', $_POST) AND Arr::get($_POST, 'bd_day') AND Arr::get($_POST, 'bd_mon') AND Arr::get($_POST, 'bd_year'))
				{
					$post['birthday'] = Arr::get($_POST, 'bd_day').'-'.Arr::get($_POST, 'bd_mon').'-'.Arr::get($_POST, 'bd_year');
				}
				$post['username'] = $this->get_unique_login('');

				$user = Jelly::factory('user');

				try
				{
					$user->create_user($post, $field_list);
				}
				catch (Jelly_Validation_Exception $e)
				{
					$this->errors($e->errors('errors'));
				}

				if ($user->saved())
				{
					try
					{
						$user->set('username', $this->get_unique_login('user'.$user->id()))->save();
					}
					catch (Jelly_Validation_Exception $e){}

					Auth_Jelly::instance()->login($user, Arr::get($_POST, 'password'), TRUE);

					if ($this->request->is_ajax())
					{
						$this->view('/clean')->echo = Utils::json_encode(array('type' => 'success'));
					}
					else
					{
						$this->redirect(Route::url('default', array('controller' => 'user', 'action' => 'edit')));
					}
				}
				else
				{
					if ($this->request->is_ajax())
					{
						$this->view('/clean')->echo = Utils::json_encode(array('type' => 'error', 'errors' => Arr::flatten($this->layout->getErrors())));
					}
				}
			}

			$this->view()->user = isset($user) ? $user : Jelly::factory('user');
		}
		else
		{
			if ($this->request->is_ajax())
			{
				$this->view('/clean')->echo = Utils::json_encode(array('type' => 'success'));
			}
			else
			{
				$this->redirect(Route::url('default', array('controller' => 'user', 'action' => 'edit')));
			}
		}
	}

	public function action_login()
	{
        if ($this->user)
        {
			$this->redirect('/');
		}

		$loginza = Loginza::instance();

        if ($_POST)
        {
	        if ($token = Arr::get($_POST, 'token'))
	        {
		        try
		        {
			        $_data = $loginza->check()->get_clear_profile();

			        $ins = Jelly::factory('loginza')->get_my(Arr::path($_data, 'system.identity'), Arr::path($_data, 'system.provider'));

			        if ($ins->loaded())
			        {
				        $user = Jelly::query('user', $ins->user_id)->limit(1)->select();
			        }
			        else
					{
						$user = $this->reg_loginza_user($_data['profile']);

						Model_Loginza::add_provider($user->id(), $_data['system']);
					}


			        if ($user->deleted)
			        {
				        $this->errors(__('auth.error.deleted'));
			        }
			        else
			        {
				        Auth_Jelly::instance()->force_login($user, FALSE, TRUE);
				        $this->redirect(Route::url('user', array('action' => 'edit')));
			        }
		        }
		        catch (Exception_Loginza $e)
		        {
			        $this->errors(__('user.login.loginza.failed'));
		        }
	        }
	        else
	        {
		        if (Arr::get($_POST, 'username') AND Arr::get($_POST, 'password'))
		        {
			        $user = Jelly::factory('user')->get_user($_POST['username']);

			        if ($user->loaded())
			        {
				        if ($user->deleted)
				        {
					        $this->errors(__('auth.error.deleted'));
				        }
				        else
				        {
					        if (Auth_Jelly::instance()->login($user, $_POST['password'], (bool) Arr::get($_POST, 'remember')))
					        {
                                $this->redirect(Route::url('user', array('action' => 'edit')));
					        }
					        else
					        {
						        $this->errors(__('auth.login.wrong'));
					        }
				        }
			        }
			        else
			        {
				        $this->errors(__('auth.login.wrong'));
			        }
		        }
		        else
		        {
			        $this->errors(__('auth.login.wrong'));
		        }
	        }
        }
		$this->view()->widget_url = $loginza->get_widget_url();
	}

	protected function reg_loginza_user($data)
	{
		if (Arr::get($data, 'email'))
		{
			$user = Jelly::query('user')->where('email', '=', $data['email'])->limit(1)->select();
			if ($user->loaded())
			{
				return $user;
			}
		}

		$data['role'] = 'login';
		$data['is_loginza'] = TRUE;
		$profile_un = Arr::get($data, 'username');

		$data['username']   = $this->get_unique_login(Arr::get($data, 'username', ''));
		$data['whatdo'] = '';
		$data['os'] = '';
		$data['pay'] = '';

		$avatar = Arr::get($data, 'avatar');
		unset($data['avatar']);

		DB::insert('users', array_keys($data))->values($data)->execute();

		$user = Jelly::query('user')->where('username', '=', $data['username'])->limit(1)->select();

		if ($user->loaded())
		{
			if ($avatar)
			{
				if ($_tmp = $this->save_tmp_ava($avatar, $user))
				{
					try
					{
						if ( ! $user->save_avatar($_tmp))
						{
							$this->errors(__('user.avatar.upload.not_saved'));
							$user->rm_avatar();
						}
					}
					catch(Kohana_Exception $e)
					{
						$this->errors(__('user.avatar.upload.not_saved'));
						$user->rm_avatar();
					}

					unlink($user->avatar_dir().$_tmp);
				}
			}

			if ( ! $profile_un)
			{
				$user->username = 'user'.$user->id();
				try
				{
					$user->save();
				}
				catch (Jelly_Validation_Exception $e)
				{
					$user->username = $data['username'];
				}
			}
		}
		else
		{
			throw new Exception_Loginza('user was not saved');
		}

		return $user;
	}

	protected function get_unique_login($login, $len = 3)
	{
		while (UTF8::strlen($login) < $len)
		{
			$login .= Utils::rand('symbol');
		}

		$unique = $this->is_unique_login($login);

		while ( ! $unique)
		{
			$login .= Utils::rand('symbol');
			$unique = $this->is_unique_login($login);
		}
		return $login;
	}

	protected function is_unique_login($login)
	{
		return Jelly::query('user')->where('username','=', $login)->count() ? FALSE : TRUE;
	}

    public function action_recover()
    {
        if ($this->user)
        {
            $this->redirect('/');
        }

        if (Arr::get($_GET, 'key'))
        {
            $user = Jelly::query('user')->where('hash', '=', Arr::get($_GET, 'key'))->limit(1)->select();
            if ($user->loaded())
            {
	            $password = NULL;
                try
                {
                    $password = Utils::rand('password');
                    $user->password = $password;
                    $user->save();
                }
                catch (Validation_Exception $e)
                {
                    $this->errors(__('user.data.send.error'));
                }

                if ($password)
                {
                    if (Email::send('new_auth_data', array('pass' => $password, 'login' => $user->username), $user->email))
                    {
                        $this->success(__('auth.recover.send.password'));
	                    $this->redirect(Route::url('user', array('action' => 'login')));
                    }
                    else
                    {
                        $this->errors(__('user.data.send.error'));
                    }
                }
            }
            else
            {
                $this->errors(__('auth.recover.key.not_found'));
            }
        }

        if ($_POST AND Arr::get($_POST, 'username'))
        {
            $email = Valid::email(Arr::get($_POST, 'username'));

            $user = Jelly::query('user')->where( 'deleted' , '=', FALSE)->where( $email ? 'email' : 'username' , '=', Arr::get($_POST, 'username'))->limit(1)->select();

            if ($user->loaded())
            {
	            if ($user->email)
	            {
		            $user->hash = Utils::hash(time(), 'recover');
		            $user->save();

		            if (Email::send('recover', array('link' => Route::url('user', array('action' => 'recover')).'?key='.$user->hash), $user->email))
		            {
			            $this->success(__('auth.recover.send.confirm'));
		            }
		            else
		            {
			            $this->errors(__('user.data.send.error'));
		            }
	            }
	            else
	            {
		            $this->errors(__('auth.recover.error.no_email'));
	            }
            }
            else
            {
                $this->errors(__('auth.recover.user.not_found'));
            }
        }

        $this->view();
    }

    public function action_logout()
    {
        if ( ! $this->user)
        {
            $this->redirect('/');
        }

        Auth_Jelly::instance()->logout(TRUE);
        
        $this->redirect('/');
    }

	public function action_edit()
	{
		if ($this->allowed())
		{
			$this->css('bootstrap-fileupload.min.css');
			$this->js('bootstrap-fileupload.min.js');

			$this->css('jquery.fancybox.css');
			$this->js('jquery/fancybox.pack.js');
			$user = $this->user;

			if ($this->user->is_admin() AND $this->request->param('id'))
			{
				$_user = Jelly::factory('user', $this->request->param('id'));
				if ($_user->loaded())
				{
					$user = $_user;
				}
				else
				{
					$this->redirect(Route::url('user', array('action' => 'edit')));
				}
			}

			if ($_POST)
			{
				$field_list = array(
					'email',
					'firstname',
					'lastname',
					'birthday',
					'whatdo',
					'mobile',
					'model',
					'city',
					'pay',
					'ym_purse',
					'wm_purse',
					'qiwi_purse',
					'vk_page',
					'operator_name',
					'card_number',
					'expiration_mon',
					'expiration_year',
				);
				try
				{
					if ($user->update_user($_POST, $field_list))
					{
						$this->redirect($this->request->uri());
					}
				}
				catch (Jelly_Validation_Exception $e)
				{
					$this->errors($e->errors('errors'));
				}
			}
			$this->view()->user = $user;
		}
		else
		{
			$this->redirect('/');
		}
	}

	public function action_password()
	{
		if ($this->allowed())
		{
			$user = $this->user;

			if ($this->user->is_admin() AND $this->request->param('id'))
			{
				$_user = Jelly::factory('user', $this->request->param('id'));
				if ($_user->loaded())
				{
					$user = $_user;
				}
				else
				{
					$this->redirect(Route::url('user', array('action' => 'edit')));
				}
			}

			$password = Utils::rand('password');

			if (Valid::email($user->email))
			{
				try
				{
					$user->set('password', $password)->save();

					if (Email::send('new_password', array('pass' => $password), $user->email))
					{
						$this->success(__('user.password.changed'));
					}
					else
					{
						$this->errors(__('user.data.send.error'));
					}
				}
				catch (Jelly_Validation_Exception $e)
				{
					$this->errors($e->errors('errors'));
				}
			}
			else
			{
				$this->errors(__('user.email.error'));
			}


			$this->redirect(Route::url('default', array('controller' => 'user', 'action' => 'edit', 'id' => $user->id())));
		}
		else
		{
			$this->redirect();
		}
	}

	public function action_delete()
	{
		if ($this->user)
		{
			$id = $this->user->id();

			if ($this->user->is_admin() AND $this->request->param('id'))
			{
				$id = $this->request->param('id');
			}

			if ( ! $this->user->is_admin() OR ($this->user->id() != $id))
			{
				$user = Jelly::factory('user', $id);

				if ($user->loaded())
				{
					if ( ! $user->deleted)
					{
						$user->deleted = TRUE;
						$user->save();
					}

					if ($user->id() == $this->user->id())
					{
						Auth_Jelly::instance()->logout();
					}
				}
			}

			$this->redirect();
		}
		else
		{
			$this->redirect();
		}
	}

	public function action_avatar()
	{
		if ($this->user)
		{
			$user = $this->user;

			if ($this->user->is_admin() AND $this->request->param('id'))
			{
				$_user = Jelly::factory('user', $this->request->param('id'));
				if ($_user->loaded())
				{
					$user = $_user;
				}
				else
				{
					$this->redirect(Route::url('user', array('action' => 'edit')));
				}
			}

			if ($file = Arr::get($_FILES, 'avatar'))
			{
				if ($this->valid_ava($file))
				{
					if ($_tmp = $this->save_tmp_ava($file, $user))
					{
						try
						{
							if ( ! $user->save_avatar($_tmp))
							{
								$this->errors(__('user.avatar.upload.not_saved'));
								$user->rm_avatar();
							}
						}
						catch(Kohana_Exception $e)
						{
							$this->errors(__('user.avatar.upload.not_saved'));
							$user->rm_avatar();
						}

						unlink($user->avatar_dir().$_tmp);
					}
				}
			}

			$this->redirect();
		}
		else
		{
			$this->redirect(Route::url('user', array('action' => 'login')));
		}
	}

	public function action_rma()
	{
		if ($this->user)
		{
			$user = $this->user;

			if ($this->user->is_admin() AND $this->request->param('id'))
			{
				$_user = Jelly::factory('user', $this->request->param('id'));
				if ($_user->loaded())
				{
					$user = $_user;
				}
				else
				{
					$this->redirect(Route::url('user', array('action' => 'edit')));
				}
			}

			$user->rm_avatar();

			$this->redirect();
		}
		else
		{
			$this->redirect(Route::url('user', array('action' => 'login')));
		}
	}

	protected function valid_ava($file)
	{
		$_config = Kohana::$config->load('user.avatar');

		if ($file AND Upload::not_empty($file) AND Upload::valid($file))
		{
			$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
			if (Upload::type($file, $_config['allowed']) AND $ext)
			{
				if (Upload::size($file, $_config['size']))
				{
					$tmp_image = Image::factory($file['tmp_name']);

					if (($tmp_image->width >= $_config['types']['thumb']['width']) AND ($tmp_image->height >= $_config['types']['thumb']['height']))
					{
						return TRUE;
					}
					else
					{
						$this->errors(__('user.avatar.upload.too_small'));
					}
				}
				else
				{
					$this->errors(__('user.avatar.upload.too_big'));
				}
			}
			else
			{
				$this->errors(__('user.avatar.upload.not_allowed_type'));
			}

		}
		else
		{
			$this->errors(__('user.avatar.upload.not_uploaded'));
		}
		return FALSE;
	}

	protected function save_tmp_ava($file, $user)
	{
		$_dir = $user->avatar_dir();

		if ( ! is_dir($_dir))
		{
			mkdir($_dir);
		}

		if (is_array($file))
		{
			$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
			$_tmp = 'tmp_'.$user->id().$ext;

			if (Upload::save($file, $_tmp, $_dir))
			{
				return $_tmp;
			}
		}
		elseif (is_string($file))
		{
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			$_tmp = 'tmp_'.$user->id().$ext;

			$_c = file_get_contents($file);

			if ($_c)
			{
				if (file_put_contents($_dir.$_tmp, $_c))
				{
					return $_tmp;
				}
			}
		}

		$this->errors(__('user.avatar.upload.not_saved'));
		return FALSE;
	}

} // End Welcome
