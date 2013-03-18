<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Static_Core extends Kohana_Controller_Template {
	
	public $template = 'static/layout';

	protected $a2;

	public function before()
	{
		parent::before();
		$this->a2 = A2::instance();
	}

	public function action_view	()
	{
		$alias = $this->request->param('alias');
		$static = Jelly::select('static')->where('alias', '=', $alias)->load();
		if ( ! $static->loaded())
		{
			Request::instance()->redirect('/');
		}
		$this->template->title = $static->title;
		$this->template->content = $static->body;
	}

	public function action_list()
	{
		if ( ! $this->a2->allowed('static', 'list'))
		{
			Request::instance()->redirect('/');
		}
		$statics = Jelly::select('static')->execute();
		$this->template->title = __('static.List');
		$this->template->content = View::factory('static/list')
										->set('statics', $statics);
	}

	public function action_add()
	{
		if ( ! $this->a2->allowed('static', 'add'))
		{
			Request::instance()->redirect(Route::url('/'));
		}
		$errors = array();
		if ($_POST)
		{
			try
			{
				Jelly::factory('static')
						->set(Arr::extract($_POST, array('title', 'body')))
						->set(array('alias' => $this->alias($_POST)))
						->save();
				Request::instance()->redirect(Route::url('static'));
			} catch (Validate_Exception $e) {
				$errors = $e->array->errors('validate');
			}
		}
		$this->template->title = __('static.Creating');
		$this->template->content = View::factory('static/add')
										->set('errors', $errors);
	}

	public function action_edit()
	{
		if ( ! $this->a2->allowed('static', 'edit'))
		{
			Request::instance()->redirect(Route::url('/'));
		}
		$errors = array();
		$static = Jelly::select('static')->load($this->request->param('id'));
		if ($static->loaded())
		{
			if ($_POST)
			{
				$alias = $this->alias($_POST);
				try
				{
					$static->set(Arr::extract($_POST, array('title', 'body')+array(
					'alias' => $alias
					)

							))
							->save();
					Request::instance()->redirect(Route::url('static'));
				}
				catch (Validate_Exception $e)
				{
					$errors = $e->array->errors('validate');
				}
			}
			$this->template->title = __('static.Editing');
			$this->template->content = View::factory('static/edit')
											->set('errors', $errors)
											->set('static', $static);
		}
		else
		{
			Request::instance()->redirect(Route::url('static'));
		}
	}

	public function action_delete()
	{
		if ( ! $this->a2->allowed('static', 'delete'))
		{
			Request::instance()->redirect(Route::url('/'));
		}
		Jelly::factory('static')->delete($this->request->param('id'));
		Request::instance()->redirect(Route::url('static'));
	}

	protected function alias($post)
	{
		$alias = mb_strtolower(Arr::get($post, 'alias', ''));
		if(preg_match('/[a-z]+/', $alias, $match))
		{
			$alias = $match[0];
		}
		else
		{
			$alias = $this->translit(Arr::get($post, 'title'));
		}
		return $alias;
	}

	protected function translit($str, $sep = '_')
	{
		$arr = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '',    'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            'ї' => 'i',   'є'=>'ye',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            'Ї' => 'Yi',  'Є'=>'Ye',
        );

        $str = strtr($str, $arr);
        $str = mb_strtolower($str);
        $str = preg_replace('/[^A-Za-z0-9 ]+/', '', $str);
        $str = preg_replace('~[^a-z0-9]+~u', $sep, $str);
        $str = trim($str, $sep);

        return $str;
	}

}