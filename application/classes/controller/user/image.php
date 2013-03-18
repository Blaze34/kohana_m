<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Image extends Controller_Web {

	protected $owner;

    public function action_add()
    {
        if ($this->allowed())
        {
	        $this->owner = $this->user;
	        if ($this->user->is_admin())
	        {
		        if (($id = $this->request->param('id')) AND ($id != $this->user->id()))
		        {
			        $user = Jelly::factory('user', $id);
			        if ($user->loaded())
			        {
				        $this->owner = $user;
			        }
		        }
	        }

            if ($_POST)
            {
                try
                {
                    if (Arr::get($_FILES['file'], 'error') === UPLOAD_ERR_OK)
                    {
                        $this->upload_image($_FILES);
                    }
                    else
                    {
                        $this->errors(__('global.no_file'));
                    }
                }
                catch(Jelly_Validation_Exception $e)
                {
                    $this->errors($e->errors('errors'));
                }
            }

	        $route_params = array('controller' => 'user', 'action' => 'edit');

	        if ($this->user->id() != $this->owner->id())
	        {
		        $route_params['id'] = $this->owner->id();
	        }

	        $this->redirect(Route::url('default', $route_params));
        }
        else
        {
            $this->redirect(Route::url('user', array('action' => 'login')));
        }
    }

    protected function upload_image($image)
    {
        $_config = Kohana::$config->load('file.image');

        $validation = Validation::factory($image)
            ->rule('file', 'Upload::valid')
            ->rule('file', 'Upload::not_empty')
            ->rule('file', 'Upload::type', array(':value', $_config['allowed']))
            ->rule('file', 'Upload::size', array(':value', $_config['size']));
        if ($validation->check())
        {
            $this->_save($validation['file']);
        }
        else
        {
            throw new Jelly_Validation_Exception('errors', $validation);
        }
    }

    protected function _save($image)
    {
        $f = Jelly::factory('user_image');
        $f->user = $this->owner;
        $f->name = Arr::get($_POST, 'file_name');
	    $f->save();

        if ($f->saved())
        {
            $_config = Kohana::$config->load('file.image');

            $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            $_tmp = 'tmp_'.$this->user->id().$ext;
            $_image = Utils::rand('image');
            $_dir = $_config['dir'].floor($f->id()/$_config['split']).'/';

            if ( ! is_dir($_dir))
            {
                mkdir($_dir);
            }

            try
            {
                if ((isset($image['tmp']) AND $image['tmp'])?rename($image['tmp'], $_dir.$_tmp):Upload::save($image, $_tmp, $_dir))
                {
                    $_valid = TRUE;

                    $result_img = Image::factory($_dir.$_tmp);
                    $result_img->render($_config['as']);

                    foreach ($_config['types'] as $type)
                    {
                        $_do = $type['do'];
                        if ($_do)
                        {
                            if ($_do == 'crop')
                            {
                                if ($result_img->width <= $result_img->height)
                                {
                                    $result_img->resize($type['width'], NULL);
                                }
                                elseif ($result_img->width >= $result_img->height)
                                {
                                    $result_img->resize(NULL, $type['height']);
                                }
                            }
                            $result_img->$_do($type['width'], $type['height']);
                        }
                        $_valid = $result_img->save($_dir.$type['prefix'].'_'.$f->id().$_image.'.'.$_config['as'], $type['quality']);
                    }

                    unlink($_dir.$_tmp);

                    if ($_valid)
                    {
                        $f->set('file', $_image)->save();
                    }
                    else
                    {
                        $f->delete();
                    }
                }
                else
                {
                    $f->delete();
                    $this->errors(__('image.error.saving'));
                }
            }
            catch(Kohana_Exception $e)
            {
                $f->delete();
                $this->errors($e->getMessage());
            }
        }
        else
        {
            $this->errors(__('image.error.saving'));
        }
    }

	public function action_delete()
	{
		if ($this->user AND ($id = $this->request->param('id')))
		{
			$return_params = array('controller' => 'user', 'action' => 'edit');

			$image = Jelly::query('user_image')->with('user')->where('id', '=', $id);

			if ( ! $this->user->is_admin())
			{
				$image->where('user', '=', $this->user->id());
			}

			$image = $image->limit(1)->select();

			if ($image->loaded())
			{
				$_config = Kohana::$config->load('file.image');
				$_dir = $_config['dir'].floor($image->id()/$_config['split']).'/';

				foreach ($_config['types'] as $type)
				{
					$_name = $type['prefix'].'_'.$image->id().$image->file.'.'.$_config['as'];
					if (file_exists($_dir.$_name))
						unlink($_dir.$_name);
				}

				if ($this->user->id() != $image->user->id())
				{
					$return_params['id'] = $image->user->id();
				}

				$image->delete();
			}

			$this->redirect(Route::url('default', $return_params));
		}
		else
		{
			$this->redirect();
		}
	}

//	protected function rmFile()
}