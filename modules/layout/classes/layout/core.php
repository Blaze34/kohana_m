<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Layout_Core {
    protected $layout = NULL;
    protected $view = NULL;
    protected $title = NULL;

    protected $css = array();
    protected $js = array();
    protected $errors = array();
    protected $success = array();

    // JS
    protected $json = array();
    protected $error = 1;

    protected $config = array();

    public static $instance = NULL;

    public static $current = NULL;
    
    /**
     * Return an instance of Layout.
     *
     * @return  object
     */
    public static function instance($_name = NULL, $_config = NULL)
    {
        static $_instances;

        if ( ! $_name)
        {
            $_name = Request::initial()->uri();
        }

        if ( ! isset($_instances[$_name]))
        {
            $_instances[$_name] = self::factory($_name, $_config);
        }
        
        self::$current = $_instances[$_name];
        
        return $_instances[$_name];
    }

    public static function factory($_name = NULL, $_config = NULL)
    {
        $instance = new Layout($_config);

        if ($_name == Request::initial()->uri())
        {
            self::$instance = $instance;
        }

        return $instance;
    }

    public static function current()
    {
        return self::$current;
    }

    /**
     * Build default Layout from config.
     *
     * @return  void
     */
    public function __construct($_config = NULL)
    {
        $_config = $_config ? $_config : 'default';

        $this->config = Kohana::$config->load('layout.'.$_config);

        if ($parent=Arr::get($this->config, 'parent'))
        {
            if ($parent = Kohana::$config->load('layout.'.$parent))
            {
                $this->config = array_replace_recursive($parent, $this->config);
            }
        }

        $this->layout = $this->config['dir'];

        $flash = Session::instance()->get_once('flash');
        if ($flash)
        {
            $flash = Jelly::query('flash', $flash)->limit(1)->select();
            if ($flash->loaded())
            {
                $flash = $flash->data;
                if (Arr::get($flash, 'errors'))
                    $this->errors($flash['errors']);
                if (Arr::get($flash, 'success'))
                    $this->success($flash['success']);
            }
        }


        // Load the layout only if request is no ajax and is the main
        if ( ! Request::current()->is_ajax() AND Request::current()->is_initial() AND ! Arr::get($_GET, 'iframe') AND ! Arr::get($_GET, 'print'))
        {
            $_type = 'main';
        }
        elseif (Request::current()->is_ajax())
        {
            $_type = 'ajax';
        }
        elseif (Arr::get($_GET, 'iframe'))
        {
            $_type = 'iframe';
        }
        elseif(Arr::get($_GET, 'print'))
        {
            $_type = 'print';
        }
        else
        {
            $_type = 'nested';
        }

        $this->layout = View::factory($this->layout . $this->config['layout'][$_type]);

        if (Arr::get($this->config, 'load') AND Arr::get($this->config['load'], $_type))
        {
            $_load = $this->config['load'][$_type];
            if (Arr::get($_load, 'css'))
            {
                foreach ($_load['css'] as $css)
                {
                    $this->css($css);
                }
            }

            if (Arr::get($_load, 'js'))
            {
                foreach ($_load['js'] as $js)
                {
                    $this->js($js);
                }
            }
        }

        self::$current = $this;
    }

    public function config()
    {
        return $this->config;
    }

    public function view($view = NULL, $data = NULL)
    {
        if (is_array($view))
        {
            $data = $view;
            $view = NULL;
        }

        if ($this->view AND ! $view)
        {
            if ($data AND is_array($data))
            {
                foreach ($data as $key => $value)
                {
                    $this->view->$key = $value;
                }
            }
            return $this->view;
        }
        if ( ! $view)
        {
            $view = Request::current()->action();
            $view = str_replace('_', '/', Request::current()->controller()).'/'.$view;
            Request::current()->directory() AND $view=Request::current()->directory().'/'.$view;
        }
        elseif ( strpos($view,'/') === FALSE OR strpos($view,'/') != 0)
        {
            $view = str_replace('_', '/', Request::current()->controller()).'/'.$view;
            Request::current()->directory() AND $view=Request::current()->directory().'/'.$view;
        }
        else
        {
            $view = substr($view, 1);
        }
        $this->view = View::factory($view);

        if ($data AND is_array($data))
        {
            foreach ($data as $key => $value)
            {
                $this->view->$key = $value;
            }
        }
        return $this->view;
    }

    public function title($title = NULL)
    {
        if ($title)
        {
            $this->title = $title;
        }

        return $this->title;
    }

    public function errors($data = NULL)
    {
        if ($data AND is_array($data))
        {
            foreach ($data as $key => $value)
            {
                $this->errors[$key] = $value;
            }
        }
        elseif ($data)
        {
            array_push($this->errors, $data);
        }
    }

    public function hasErrors()
    {
        return sizeof($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function success($data = NULL)
    {
        if ($data AND is_array($data))
        {
            foreach ($data as $key => $value)
            {
                $this->success[$key] = $value;
            }
        }
        elseif ($data)
        {
            array_push($this->success, $data);
        }
    }

    public function hasSuccess()
    {
        return sizeof($this->success);
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function __set($key, $value = NULL)
    {
        $this->layout->$key = $value;
    }

    public function __get($key)
    {
        return $this->layout->$key;
    }

    public function layout()
    {
        return $this->layout;
    }

    public function render()
    {
        $this->layout->content = $this->view ? $this->view->render() : '';


        if (Arr::get($_REQUEST, 'jinnee'))
        {
            if ($this->errors)
            {
                $this->layout->errors = $this->errors;
            }
            if ($this->success)
            {
                $this->layout->success = $this->success;
            }
            if ($this->json)
            {
                $this->layout->json = $this->json;
            }
            $this->layout->error = $this->error;
            //Request::$instance->headers['Content-Type'] = 'application/x-javascript';
        }
        else
        {
            $errors = View::factory('errors');
            $errors->errors = Arr::map('__', self::array_flatten($this->errors));

            $success = View::factory('success');
            $success->success = Arr::map('__', self::array_flatten($this->success));

            $this->layout->errors = $errors->render();
            $this->layout->success = $success->render();
        }

        // Initialize style values

        $meta = $this->_meta;

        if ( ! $meta['title']) $meta['title'] = $this->title;

        $meta['title'] = ($meta['title'] ? $meta['title'].' - ' : '') . $this->config['title'];

        $this->layout->meta = $meta;
        $this->layout->title = $this->title;
        $this->layout->css  = array_unique($this->css);
        $this->layout->js = array_unique($this->js);
        $this->layout->speedbar = sizeof($this->_speedbar) ? View::factory('layout/speedbar')->set('speedbar', $this->_speedbar)->render() : '';

        return $this->layout->render();
    }

    private static function array_flatten($array) {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, self::array_flatten($value));
            }
            else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * Adding java script files into header
     * @param null $path
     * @param bool $default
     * @return Layout_Core
     */
    public function js($path = NULL, $default = TRUE)
    {
        if ($path)
        {
            if (!is_array($path))
            {
                $path = array($path);
            }

            foreach ($path as $value)
            {
                if ((strpos($value, 'http://') === FALSE AND strpos($value, 'https://') === FALSE)
                        OR
                    (strpos($value, 'http://') != 0 AND strpos($value, 'https://') != 0))
                {
                    array_push($this->js, $default ? $this->config['js']['path'].$value : $value);
                }
                else
                {
                    array_push($this->js, $value);
                }
            }
        }

        return $this;
    }

    /**
     * Adding style files into header
     * @param null $path
     * @param bool $default
     * @return Layout_Core
     */
    public function css($path = NULL, $default = TRUE)
    {
        if ($path)
        {
            if (!is_array($path))
            {
                $path = array($path);
            }

            foreach ($path as $value)
            {
                if ((strpos($value, 'http://') === FALSE AND strpos($value, 'https://') === FALSE)
                        OR
                    (strpos($value, 'http://') != 0 AND strpos($value, 'https://') != 0))
                {
                    array_push($this->css, $default ? $this->config['css']['path'].$value : $value);
                }
                else
                {
                    array_push($this->css, $value);
                }
            }
        }

        return $this;
    }

    /**
     * Views json data
     * @param null $data
     * @param int $error
     * @return void
     */
    public function json($data = NULL, $error = 0)
    {
        $this->error = $error;
        if ($data)
        {
            if (is_array($data))
            {
                $this->json = $data;
            }
            else
            {
                $this->json = array($data);
            }
        }
    }

    protected $_meta = array(
        'title' => NULL,
        'description' => NULL,
        'keywords' => NULL
    );

    public function meta(array $meta)
    {
        foreach ($meta as $k => $v)
        {
            if ($v AND array_key_exists($k, $this->_meta))
            {
                if ($k == 'description') $v = Text::limit_chars($v, 200);
                if ($k == 'keywords') $v = Text::limit_chars($v, 1000);
                $this->_meta[$k] = $v;
            }
        }
    }

    protected $_speedbar = array();
    public function speedbar(array $item, $level = NULL)
    {
        if ( ! is_array(reset($item)))
        {
            $item = array($item);
        }
        if ($level)
        {
            $this->_speedbar[$level] = $item;
        }
        else
        {
            $this->_speedbar = $item;
        }
    }
}
