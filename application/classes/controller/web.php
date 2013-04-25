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
    public $settings = array();

	/**
	 * Loads the template [View] object.
	 */
	public function before()
	{
        $return = parent::before();

        // Loading current authorized user
        $user = Auth::instance()->get_user();

		if (Request::current()->is_initial() AND ! $this->request->is_ajax())
		{
			if ($user)
			{
				$user = Jelly::factory('user', $user->id());
				Auth::instance()->resession($user);
			}
		}

		$this->user = $user;

        // global site settings
        $settings = Admin::settings();

        foreach($settings as $s)
        {
            $this->settings[$s->title] =  $s->status;
        }

        $this->layout->layout()->set_global($this->settings);

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
