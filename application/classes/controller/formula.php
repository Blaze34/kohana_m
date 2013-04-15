<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Formula extends Controller_Web {

    public function before()
    {
        if ($this->request->action())
        {
            $this->layout = 'admin';
        }
        return parent::before();
    }

	public function action_index()
	{
        if ($this->allowed())
        {

            $formula = Jelly::query('formula')->pagination('formula')->select_all();

            $this->view(array('formula' => $formula));
        }
        else
        {
            $this->redirect('/');
        }
	}

    public function action_edit()
    {
        if ($this->allowed())
        {
            if($id = $this->request->param('id'))
            {
                $formula = Jelly::query('formula')->where('id', '=', $id)->limit(1)->select();

                if($_POST)
                {
                    $new = mb_strtolower(Arr::get($_POST, 'formula'));
                    $check = (isset($_POST['check'])? TRUE : FALSE);
                    $valid = $this->check_formula($new);

                    if($valid['valid'])
                    {
                        if(!$check AND $valid['calculate'])
                        {
                            $formula->set(array('formula' => $new));

                            $formula->save();

                            if($formula->saved())
                            {
                                $this->redirect(Route::url('default', array('controller' => 'formula', 'action' => 'recount')));
                            }
                            else
                            {
                                $this->errors('error.save')->redirect();
                            }
                        }
                    }
                    else
                    {
                        $this->errors('Формула введена не верно!');
                    }
                }

                $this->view(array('formula' => $formula, 'check_formula' => $valid));
            }
            else
            {
                $this->errors('global.no_params')->redirect();
            }
        }
    }

    public function action_materials ()
    {
        if($this->allowed())
        {
            $materials = Jelly::query('material')->pagination('formula')->select_all();

            $this->view(array('materials' => $materials));
        }
        else
        {
            $this->redirect('/');
        }
    }

    public function action_recount ()
    {
        if($this->allowed())
        {
            $materials = Jelly::query('material')->select_all();

            $output = array('msg' => '', 'err' => '');

            foreach ($materials as $m)
            {
                if($m->total_recount())
                {
                    $output['msg'] = 'Пересчет успешно завершен!';

                }
                else
                {
                    $output['err'] = 'Пересчет завершен c ошибками!';
                }
            }

            $this->errors($output['err'] ? $output['err'] : $output['msg'])->redirect();
        }
        else
        {
            $this->redirect('/');
        }
    }

    private function check_formula($str, $calc = FALSE)
    {
        $output = array('valid' => FALSE, 'formula' => $str, 'calculate' => '', 'eval' => '');

        $l = 10;
        $d = 2;
        $t = 2;
        $c = 12;
        $v = 24;

        $temp = $str;

        $tokens = array(
            '$t',   '$v',   '$l',   '$d',
            '$c',   '+',    '-',    '(',
            ')',    '*',    '/',    '',
            '0',    '1',    '2',    '3',
            '4',    '5',    '6',    '7',
            '8',    '9',    ' '
        );

        if(strlen($str) >= 1)
        {

            $regex = preg_match('#(?:\d\$|[tvcld]\d|[tvcld][(]\$)+#', $str);
            if(!$regex)
            {
                foreach ($tokens as $t)
                {
                    if(strlen($str) == 0)
                    {
                        break;
                    }

                    $str = str_replace($t, '', $str);
                }

                if(strlen($str) == 0)
                {
                    $output['valid'] = TRUE;
                    $output['eval'] = eval("\$output['calculate'] = (int)round($temp);");

                    return $output;
                }
            }

            return false;
        }
    }

} // End Welcome
