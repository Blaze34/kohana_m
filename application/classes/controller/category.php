    <?php defined('SYSPATH') or die('No direct script access.');

class Controller_Category extends Controller_Web {
    public function before()
    {
        if (in_array($this->request->action(), array('index', 'add', 'edit')))
        {
            $this->layout = 'admin';
        }
        return parent::before();
    }

    public function action_index()
    {
        if ($this->allowed())
        {
            $categories = Jelly::query('category')->order_by('parent_id')->order_by('sort')->order_by('id')->select_all();

            $struct = array();

            foreach ($categories as $c)
            {
                if ($c->parent_id)
                {
                    $struct[$c->parent_id]['children'][$c->id()] = array('name' => $c->name, 'sort' => $c->sort);
                }
                else
                {
                    $struct[$c->id()] = array('name' => $c->name, 'sort' => $c->sort, 'children' => array());
                }
            }
            $this->view()->categories = $struct;
        }
        else
        {
            $this->redirect();
        }
    }

    public function action_add()
    {
        if ($this->allowed())
        {
            $categories = Jelly::query('category')->where('parent_id', '=', 0)->order_by('sort')->select_all()->as_array('id', 'name');

            $category = Jelly::factory('category');

            if ($_POST)
            {
                try
                {
                    $category->set(array(
                        'name' => Arr::get($_POST, 'name'),
                        'sort' => Arr::get($_POST, 'sort'),
                        'parent_id' => Arr::get($_POST, 'parent_id'),
                    ))->save();
                }
                catch (Jelly_Validation_Exception $e)
                {
                    $this->errors($e->errors('errors'));
                }

                if ($category->saved())
                {
                    $this->redirect(Route::url('default', array('controller' => 'category')));
                }
            }

            $this->view()->category = $category;
            $this->view()->categories = $categories;
        }
        else
        {
            $this->error('global.no_permisson')->redirect('/');
        }
    }

    public function action_edit()
    {
        if ($this->allowed())
        {
            $categories = Jelly::query('category')->where('parent_id', '=', 0)->order_by('sort')->select_all()->as_array('id', 'name');

            $category = Jelly::factory('category', $this->request->param('id'));

            if ($category->loaded())
            {
                if ($_POST)
                {
                    try
                    {
                        $category->set(array(
                            'name' => Arr::get($_POST, 'name'),
                            'sort' => Arr::get($_POST, 'sort'),
                            'parent_id' => Arr::get($_POST, 'parent_id'),
                        ))->save();
                    }
                    catch (Jelly_Validation_Exception $e)
                    {
                        $this->errors($e->errors('errors'));
                    }

                    if ($category->saved())
                    {
                        $this->redirect(Route::url('default', array('controller' => 'category')));
                    }
                }
                $this->view()->category = $category;
                $this->view()->categories = $categories;
            }
            else
            {
                $this->redirect(Route::url('default', array('controller' => 'category')));
            }
        }
        else
        {
            $this->redirect('/');
        }
    }

    public function action_show()
    {
        $category = Jelly::factory('category', $id = $this->request->param('id'));

        if($category->loaded())
        {

            $this->title($category->name, FALSE);
            $materials = $children = $child = $comments = $ids = array();

            $sort = 'popular_category';

            if(isset($_GET['popular']))
            {
                $sort = 'popular_category';
            }
            elseif(isset($_GET['commented']))
            {
                $sort = 'commented_category';
            }

            $materials = Jelly::query('material')->with('user')->where('category', '=', $category->id())->order_by($sort, 'DESC')->pagination()->select_all();

            $comments = Jelly::query('comment')->with('material')->where('category_id', '=', $category->id())->order_by('id', 'DESC')->select_all();

            if(sizeof($category->children))
            {
                foreach($category->children as $ch)
                {
                    $ids[] = $ch->id();
                }

                $comments = Jelly::query('comment')->with('material')->where('category_id', 'IN', $ids)->order_by('date', 'DESC')->select_all();
                $materials = Jelly::query('material')->with('user')->where('category', 'IN', $ids)->order_by($sort, 'DESC')->pagination()->select_all();
                $children = $category->get('children')->order_by('sort')->order_by('id')->select()->as_array('id');
            }

            if ($category->parent_id)
            {

                $child = $category;

                $category = Jelly::factory('category', $category->parent_id);

                if(!sizeof($comments))
                {
                    foreach ($category->children as $c)
                    {
                        $ids[] = $c->id();
                    }

                    $comments = Jelly::query('comment')->with('material')->where('category_id', 'IN', $ids)->order_by('date', 'DESC')->select_all();

                }

            }
            $holder = Jelly::query('holder')->where('category', '=', $id)->limit(1)->select();
            $this->view(array('materials' => $materials, 'holder' => $holder, 'category' => $category, 'children' => $children, 'child' => $child, 'comments' => $comments));

        }
        else
        {
            $e = new HTTP_Exception_404();

            throw $e;

//            $this->error('global.no_exists')->redirect(Route::url('default', array('controller' => 'category')));
        }
    }


    public function action_delete()
    {
        if ($this->allowed())
        {
            $category = Jelly::factory('category', $this->request->param('id'));

            if ($category->loaded())
            {
                if(sizeof($category->children))
                {
                    $this->errors(__('category.error.has_children'));
                }
                else
                {
                    $category->delete();
                }
            }
        }
        $this->redirect();
    }

    public function action_slider()
    {
        $categories = Jelly::query('category')->order_by('parent_id')->order_by('sort')->order_by('id')->select_all();

        $struct = array();
        foreach ($categories as $c)
        {
            if ($c->parent_id)
            {
                $struct[$c->parent_id]['children'][$c->id()] = $c->name;
            }
            else
            {
                $struct[$c->id()] = array('name' => $c->name, 'children' => array());
            }
        }
        $this->view()->categories = $struct;
    }

}
