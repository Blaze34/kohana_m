<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Controller class for automatic templating with layouts.
 *
 * @category   Controller
 * @author     Altos
 */
class Controller_Layout extends Controller {

    protected $layout = NULL;

    /**
	 * Creating Layout instance with controller settings
     *
     * @return void
     */
	public function before()
	{
        $this->layout = Layout::instance($this->request->uri(), $this->layout);
		return parent::before();
	}

    /**
     * Set up and return view
     * 
     * @param null $view path to template
     * @param null $data
     * @return View
     */
    public function view($view = NULL, $data = NULL){
        return $this->layout->view($view, $data);
    }

	/**
	 * Assigns the template [View] as the request response.
	 */
	public function after()
	{
        /**
         * @todo Is needed to generate view object by auto?
         */
        // render view if defined

        $this->response->body($this->layout->render());

        return parent::after();
	}

    /**
     * Adding error message
     * @param null $data
     * @return Controller_Layout
     */
    public function errors($data = NULL)
    {
        $this->layout->errors($data);
        return $this;
    }

    /**
     * Adding success message
     * @param mixed $data error message
     * @return void
     */
    public function success($data = NULL)
    {
        $this->layout->success($data);
        return $this;
    }

    /**
     * Adding java script files into header
     * @param mixed $path scripts files
     * @param bool $default_path set from Kohana::config('media.scripts.path')
     * @return void
     */
    public function js($path = NULL, $default = TRUE)
    {
        $this->layout->js($path, $default);
        return $this;
    }

     /**
     * Adding style files into header
     * @param mixed $path style files
     * @param bool $default_path set from Kohana::config('media.styles.path')
     * @return void
     */
    public function css($path = NULL, $default = TRUE)
    {
        $this->layout->css($path, $default);
        return $this;
    }

    /**
     * Provides json data processing
     * @param array $data
     * @return Controller
     */
    public function json($data = NULL, $error = 0)
    {
        $this->layout->json($data, $error);
        return $this;
    }
    /**
     * Provides redirect with errors and success messages saving
     * @param string $url url to redirect
     * @param int $code http request code
     * @return void
     */
    public function redirect($url = NULL , $code = 302)
    {
        $data = array();
        if ($this->layout)
        {
            if ($this->layout->hasErrors())
                $data['errors'] = $this->layout->getErrors();
            if ($this->layout->hasSuccess())
                $data['success'] = $this->layout->getSuccess();
        }
        if (sizeof($data))
        {

            $flash = Jelly::factory('flash')->set(array('data' => $data, 'user' => Auth::instance()->get_user()))->save();
            Session::instance()->set('flash', $flash->id());
        }
        if ( ! $url)
        {
            $url = Request::initial()->referrer() AND URL::site($_SERVER['REQUEST_URI'], TRUE) != Request::initial()->referrer() ? Request::initial()->referrer() : URL::base();
        }
        else if ($url=='/')
        {
            $url = URL::base();
        }
        $this->request->redirect($url, $code);
    }

    public function meta($title, $description = NULL, $keywords = NULL)
    {
        $meta = array();
        if (is_array($title))
        {
            $meta = $title;
        }
        elseif ($title OR $description OR $keywords)
        {
            if ($title) $meta['title'] = $title;
            if ($description) $meta['description'] = $description;
            if ($keywords) $meta['keywords'] = $keywords;
        }
        $this->layout->meta($meta);
    }


    /**
     * Setting title to the layout
     * @param  $title
     * @param bool $auto_i18n if set true, adding to title prefix 'page.title.'
     * @return
     */
    public function title($title, $auto_i18n = TRUE)
    {
        if ($auto_i18n)
        {
            $title = 'title.' . $title;
        }
        return $this->layout->title(__($title));
    }

    public function speedbar(array $item = NULL, $level = NULL, $auto_i18n = TRUE)
    {
        if ( ! $item)
        {
            try {
                $route = $this->request->controller.'_index';
                Route::get($route);
            }
            catch (Kohana_Exception $e)
            {
                $route = 'index';
            }

            $item = array(
                array( __(($auto_i18n ? 'speedbar.' : '').$this->request->controller) => Route::url($route, array('controller' => $this->request->controller))),
            );
            /*if ($this->request->action != 'index')
            {
                $item[] = array('speedbar.'.$this->request->action => 'speedbar.'.$this->request->action);
            }*/
        }
        $this->layout->speedbar($item, $level);
    }
} // End Controller_Layout
