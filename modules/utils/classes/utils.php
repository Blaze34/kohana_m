<?php defined('SYSPATH') OR die('No direct access allowed.');

class Utils {

    public static function convert_date($date)
    {

        if(preg_match('/^\d+$(\d+)?/',$date))
        {
            $time = Date::span($date, time());

            if(is_array($time))
            {
                $output = '';

                if ($time['years'] > 0)
                {
                    $output .= $time['years'].' г. ' ;
                }

                if ($time['months'] > 0)
                {
                    $output .= $time['months'].' мес. ' ;
                }

                if ($time['weeks'] > 0)
                {
                    $output .= $time['weeks'].' нед. ' ;
                }

                if ($time['days'] > 0)
                {
                    $output .= $time['days'].' дн. ' ;
                }

                if ($time['hours'] > 0)
                {
                    $output .= $time['hours'].' ч. ' ;
                }

                if ($time['minutes'] > 0)
                {
                    $output .= $time['minutes'].' мин. ' ;
                }

                if ($time['seconds'] > 0 AND $time['minutes'] == 0)
                {
                    $output .= $time['seconds'].' сек. ' ;
                }

                return $output;
            }
        }
        return false;
    }

    public static function translit_url($str, $sep = '_')
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
            'ї' => 'i',   'є'=>'ie',

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
        $str = strtolower($str);
        $str = preg_replace('/[^A-Za-z0-9 ]+/', '', $str);
        $str = preg_replace('~[^a-z0-9]+~u', $sep, $str);
        $str = trim($str, $sep);

        return $str;
    }

    public static function translit($str, $sep = '_')
    {
       return self::translit_url($str, $sep);    
    }



    public static function hash($string = NULL, $config = 'default')
    {
        $config = Kohana::$config->load('utils.hash.'.$config);
	    return hash($config['method'], $string.$config['salt']);
    }

    public static function rand($config = 'default')
    {
        $config = Kohana::$config->load('utils.rand.'.$config);
        $charset = $config['charset'];
        $chars_length = (strlen($charset) - 1);
        $string = $charset{rand(0, $chars_length)};
        for ($i = 1; $i < $config['length']; $i = strlen($string))
        {
            $r = $charset{rand(0, $chars_length)};
            if ($r != $string{$i - 1})
            {
                $string .=  $r;
            }
        }
        return $string;
    }

    public static function number_ending($num, $word, $default = TRUE)
    {
        if ($word)
        {
            if ($default AND $num == 0)
            {
                return __($word.'_def');
            }
            else
            {
                $num100 = $num % 100;
                $num10 = $num % 10;

                if ($num100 >= 5 AND $num100 <= 20)
                    return __($word.'_0', array(':num' => $num));
                elseif ($num10 == 0)
                    return __($word.'_0', array(':num' => $num));
                elseif ($num10 == 1)
                    return __($word.'_1', array(':num' => $num));
                elseif ($num10 >= 2 AND $num10 <= 4)
                    return __($word.'_2', array(':num' => $num));
                elseif ($num10 >= 5 AND $num10 <= 9)
                    return __($word.'_0', array(':num' => $num));
                else
                    return __($word.'_2', array(':num' => $num));
            }
        }
        return;
    }

    public static function json_encode(array $data = NULL)
    {
        if (is_string($data))
        {
            return $data;
        }

        if ( ! is_array($data))
        {
            return NULL;
        }

        $isArray = true;
        $keys = array_keys($data);
        $prevKey = -1;

        // Необходимо понять — перед нами список или ассоциативный массив.
        foreach ($keys as $key)
            if (!is_numeric($key) || $prevKey + 1 != $key)
            {
                $isArray = false;
                break;
            }
            else
                $prevKey++;

        unset($keys);
        $items = array();

        foreach ($data as $key => $value)
        {
            $item = (!$isArray ? "\"$key\":" : '');

            if (is_array($value))
                $item .= Utils::json_encode($value);
            elseif (is_null($value))
                $item .= 'null';
            elseif (is_bool($value))
                $item .= $value ? 'true' : 'false';
            elseif (is_string($value))
                $item .= '"' . preg_replace(
                    '%([\\x00-\\x1f\\x22\\x5c])%e',
                    'sprintf("\\\\u%04X", ord("$1"))',
                    $value
                ) . '"';
            elseif (is_numeric($value))
                $item .= $value;
            /*else
                throw new Exception('Wrong argument.');*/

            $items[] = $item;
        }

        return
            ($isArray ? '[' : '{') .
            implode(',', $items) .
            ($isArray ? ']' : '}');
    }

    public static function time_to ($date){

        $now = time();

        $year_to = ($now - $date) / 31536000;
        $month_to = ($now - $date) / 2592000;
        $day_to = ($now - $date) / 86400;
        $hour_to = ($now - $date) / 3600;
        $minute_to = ($now - $date) / 60;
        $second_to = ($now - $date);

        if($year_to > 1){
            return self::number_ending(intval($year_to), 'utils.time_to.year').' '.self::number_ending(intval($month_to-intval($year_to)*12), 'utils.time_to.month', FALSE);
        } elseif($month_to > 1){
            return self::number_ending(intval($month_to), 'utils.time_to.month').' '.self::number_ending(intval($day_to-intval($month_to)*30), 'utils.time_to.day', FALSE);
        } elseif($day_to > 1){
            return self::number_ending(intval($day_to), 'utils.time_to.day').' '.self::number_ending(intval($hour_to-intval($day_to)*24), 'utils.time_to.hour', FALSE);
        } elseif ($hour_to > 1){
            return self::number_ending(intval($hour_to), 'utils.time_to.hour').' '.self::number_ending(intval($minute_to-intval($hour_to)*60), 'utils.time_to.minute', FALSE);
        } elseif ($minute_to > 1){
            return self::number_ending(intval($minute_to), 'utils.time_to.minute').' '.self::number_ending(intval($second_to-intval($minute_to)*60), 'utils.time_to.second', FALSE);
        } else {
            return self::number_ending(intval($second_to), 'utils.time_to.second');
        }
    }

    public static function toHRSize($size){
        $unit = array('b','Kb','Mb','Gb','Tb','Pb','Eb');
        $i = (int) floor(log($size)/log(1024));
        if ( ! array_key_exists($i, $unit)) return '';
        return round( $size / pow(1024, $i) ).''.$unit[$i];
    }


    public static function sorting($field, $default){
        $dir = FALSE;

        if (Arr::get($_GET, 's'))
        {
            $_field = str_replace('!', '', $_GET['s']);
            $dir = ($_field != $_GET['s']);
        }

        if (isset($_field) AND $_field == $field)
        {
            if ($field == $default AND $dir)
            {
                return HTML::anchor(Request::current()->url(), '', array('class'=>'arrow_up_icon'));
            }

            return HTML::anchor(Request::current()->url().URL::query(array('s'=> ($dir?'':'!').$field)), '', array('class'=>$dir?'arrow_up_icon':'arrow_down_icon'));
        }
        elseif( ! isset($_field) AND ! $dir AND $field == $default)
        {
            return HTML::anchor(Request::current()->url().URL::query(array('s'=> '!'.$field)), '', array('class'=>'arrow_down_icon'));
        }
        else
        {
            return HTML::anchor(Request::current()->url().URL::query(array('s'=> $field!=$default?$field:NULL)), '', array('class'=>'arrow_up_icon'));
        }
    }

	public static function check_cat_id($categories, $user){
		$cat_id = array();
        if (is_array($categories) AND sizeof($categories) AND ($user->access OR $user->is_admin()))
		{
			require_once Kohana::find_file('vendor', 'sphinxclient');
			$config = Kohana::$config->load('search');
			$client = new SphinxClient();
			$client->SetServer ( $config['host'], $config['port'] );
			$client->SetConnectTimeout ( $config['timeout'] );
			$client->SetMatchMode ( SPH_MATCH_EXTENDED2 );
			$client->SetArrayResult ( true );
			$client->SetRankingMode ( SPH_RANK_PROXIMITY_BM25 );

            if (!$user->is_admin())
            {
                $client->SetFilter('access', $user->access);
            }


			$client->SetFilter('cat', $categories);
			$client->SetGroupBy ( "cat", SPH_GROUPBY_ATTR );
            $client->SetGroupDistinct ( "doc_id" );

			$client->SetLimits(0, 1000);

			$res = $client->Query ('', 'main, main_delta' );
			//echo Debug::vars($client->GetLastError());

			//echo Debug::vars($res);
			//echo Debug::vars($this->user);
			if (Arr::get($res, 'matches'))
			{
				foreach (Arr::get($res, 'matches') as $m)
				{
					$cat_id[Arr::get(Arr::get($m, 'attrs'), 'cat')] = Arr::get(Arr::get($m, 'attrs'), '@distinct');
				}
			}
		}

        return $cat_id;
    }

	public static function get_creator($like){
		require_once Kohana::find_file('vendor', 'sphinxclient');
		$config = Kohana::$config->load('search');
		$client = new SphinxClient();
		$client->SetServer ( $config['host'], $config['port'] );
		$client->SetConnectTimeout ( $config['timeout'] );
		$client->SetMatchMode ( SPH_MATCH_ANY );
		$client->SetArrayResult ( true );
		$client->SetRankingMode ( SPH_RANK_PROXIMITY_BM25 );

		$client->SetLimits(0, 1000);

		$res = $client->Query ($like, 'creators, creators_delta' );
		//echo Debug::vars($like);
		//echo Debug::vars($client->GetLastError());

		//echo Debug::vars($res);
		$creators = array();
		if (Arr::get($res, 'matches'))
		{
			foreach (Arr::get($res, 'matches') as $m)
			{
				$creators[] = crc32(Arr::get(Arr::get($m, 'attrs'), 'creator'));
			}
		}

        return $creators;
    }

    /**
     * close all open xhtml tags at the end of the string
     * @param string $html
     * @return string
     * @author Milian <mail@mili.de>
     */
    public static function closetags($html)
    {
        #put all opened tags into an array
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];   #put all closed tags into an array
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        # all tags are closed
        if (count($closedtags) == $len_opened)
        {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        # close tags
        for ($i=0; $i < $len_opened; $i++)
        {
            if (!in_array($openedtags[$i], $closedtags))
            {
                $html .= '</'.$openedtags[$i].'>';
            }
            else
            {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

    public static function array_map_recursive($func, $array) {
        foreach ($array as $key => $val) {
            if ( is_array( $array[$key] ) ) {
                $array[$key] = Utils::array_map_recursive($func, $array[$key]);
            } else {
                $array[$key] = call_user_func( $func, $val );
            }
        }
        return $array;
    }
}