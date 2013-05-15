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
                    $struct[$c->parent_id]['children'][$c->id()] = array('title' => $c->title, 'sort' => $c->sort, 'meta_title' => $c->meta_title);
                }
                else
                {
                    $struct[$c->id()] = array('title' => $c->title, 'sort' => $c->sort, 'meta_title' => $c->meta_title,  'children' => array());
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
            $categories = Jelly::query('category')->where('parent_id', '=', 0)->order_by('sort')->select_all()->as_array('id', 'title');

            $category = Jelly::factory('category');

            if ($_POST)
            {
                try
                {
                    $category->set(array(
                        'title' => Arr::get($_POST, 'title'),
                        'meta_title' => Arr::get($_POST, 'meta_title'),
                        'mask_title' => Arr::get($_POST, 'mask_title'),
                        'meta_desc' => Arr::get($_POST, 'meta_desc'),
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
            $categories = Jelly::query('category')->where('parent_id', '=', 0)->order_by('sort')->select_all()->as_array('id', 'title');

            $category = Jelly::factory('category', $this->request->param('id'));

            if ($category->loaded())
            {
                if ($_POST)
                {
                    try
                    {
                        $category->set(array(
                            'title' => Arr::get($_POST, 'title'),
                            'meta_title' => Arr::get($_POST, 'meta_title'),
                            'mask_title' => Arr::get($_POST, 'mask_title'),
                            'meta_desc' => Arr::get($_POST, 'meta_desc'),
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
            $this->meta(Admin::set_meta($category));

            $materials = $parent = $children = $child = $comments = $cids = $mids = array();

            $sort = 'popular_category';

            if(isset($_GET['popular']))
            {
                $sort = 'popular_category';
            }
            elseif(isset($_GET['commented']))
            {
                $sort = 'commented_category';
            }

            $materials = $category->get('materials')->order_by($sort, 'DESC')->pagination()->select_all();

            $flag_parent = ($category->parent_id ?  FALSE: TRUE);

            if ( ! $flag_parent)
            {
                $parent = Jelly::factory('category', $category->parent_id);

                if(sizeof($category->materials))
                {
                    $mids = $category->materials->as_array('id', 'id');

                    $comments = Jelly::query('comment')->where('material', 'IN', $mids)->select_all();
                }
            }

            if($flag_parent OR ($parent AND !sizeof($comments)))
            {
                $children = $category->get('children')->order_by('sort')->order_by('id')->select()->as_array('id');

                if($parent AND !sizeof($comments)) $category = $parent;

                $cids = $category->children->as_array('id', 'id') + array($category->id());

                $mids = DB::select('material_id')
                    ->from('categories_materials')
                    ->where('category_id', 'IN', DB::expr('('.implode(', ', $cids).')'))
                    ->group_by('material_id')
                    ->execute()->as_array('material_id', 'material_id');

                if(sizeof($mids))
                {
                    if($flag_parent)
                    {
                        $materials = Jelly::query('material')->where('id', 'IN', $mids)->order_by($sort, 'DESC')->pagination()->select_all();
                    }

                    $comments = Jelly::query('comment')->where('material', 'IN', $mids)->select_all();
                }
            }

//            if(!sizeof($comments))
//            {
//
//                if(sizeof($parent->children))
//                {
//                    $children = $parent->get('children')->order_by('sort')->order_by('id')->select()->as_array('id');
//
//                    $cids = $parent->children->as_array('id', 'id') + array($parent->id());
//
//                    $mids = DB::select('material_id')
//                        ->from('categories_materials')
//                        ->where('category_id', 'IN', DB::expr('('.implode(', ', $cids).')'))
//                        ->group_by('material_id')
//                        ->execute()->as_array('material_id', 'material_id');
//
//                    if(sizeof($mids))
//                    {
//                        $comments = Jelly::query('comment')->where('material', 'IN', $mids)->select_all();
//                    }
//                }
//            }

            $holder = Jelly::query('holder')->where('category', '=', $id)->limit(1)->select();
            $this->view(array('materials' => $materials, 'holder' => $holder, 'category' => $category, 'children' => $children, 'parent' => $parent, 'comments' => $comments));

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
                $struct[$c->parent_id]['children'][$c->id()] = $c->title;
            }
            else
            {
                $struct[$c->id()] = array('name' => $c->title, 'children' => array());
            }
        }
        $this->view()->categories = $struct;
    }

}
