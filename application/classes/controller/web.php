<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Controller class for automatic templating with layouts.
 *
 * @category   Controller
 */

class Controller_Web extends Controller_Layout {

    protected $layout = NULL;

	/**
	 * @var  string  page template
	 */
    public $user = NULL;

	/**
	 * Loads the template [View] object.
	 */
	public function before()
	{
        $return = parent::before();

        // Loading current authorized user
        $user = Auth::instance()->get_user();
		$auth_data = array('auth_name' => NULL, 'auth_pass' => NULL, 'popup_msg' => NULL);

		if (Request::current()->is_initial() AND ! $this->request->is_ajax())
		{
			if ($user)
			{
				$user = Jelly::factory('user', $user->id());
				Auth::instance()->resession($user);

				$auth_data['auth_name'] = $user->username;
				$auth_data['auth_pass'] = $this->get_hash($user);
				$auth_data['popup_msg'] = $user->is_admin() ? 0 : 1;
			}
			$this->layout->layout()->set_global($auth_data);
		}

		$this->user = $user;

		if ($this->user AND $this->user->deleted)
		{
			Auth_Jelly::instance()->logout();
			$this->redirect(Route::url('user', array('action' => 'login')));
		}

        if ($this->request->controller() != 'index')
        {
            $this->title($this->request->controller().'.'.$this->request->action());
        }

		return $return;
	}

	protected function get_hash($user)
	{
		$salt = DB::select('value')->from('storage')->where('name', '=', 'salt')->limit(1)->execute();

		return md5($user->id.$user->username.$salt->get('value'));
	}

    public function allowed($resource = NULL, $privilege = NULL)
    {
        if ( ! $resource)
            $resource = $this->request->controller();
        if ( ! $privilege)
            $privilege = $this->request->action();

        if (A2::instance()->allowed($resource, $privilege))
        {
            return TRUE;
        }

        return FALSE;
    }
}
