<?php defined('SYSPATH') or die('No direct script access.');

class Jelly_Builder extends Jelly_Core_Builder/* extends Jelly_Builder_Sortable*/
{
    public function pagination($config = 'default', $_config = array())
    {
        $_tmp = clone $this;

        $pagination = Pagination::factory();
        $pag_conf = $pagination->config_group($config);

        $pag_conf = array_merge($pag_conf, $_config);
        
        if ($pag_conf['current_page']['source'] == 'query_string')
        {
            $page =  max(1, Arr::get($_GET, $pag_conf['current_page']['key']));
        }
        else
        {
            $page =  max(1, Request::initial()->param($pag_conf['current_page']['key']));
        }
        
        $offset = $pag_conf['items_per_page'] * ($page-1);
        $pagination->setup($pag_conf);
        $pagination->__set('total_items', $_tmp->count());

        Layout::$current->view()->pagination = $pagination->render();

        return $this->limit($pag_conf['items_per_page'])->offset($offset);
    }


    public function site( $supplier = 'supplier.id' )
    {
        return $this->join('sites_suppliers', 'inner')->on('sites_suppliers.supplier_id', '=', $supplier)->on('sites_suppliers.site_id', '=', DB::expr(Session::instance()->get('site')->id()));
    }
}