<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
$route['^dashboard/menu$']                  = 'menus/menus_admin/dispatcher/list_menu/vi';
$route['^dashboard/menu/(\w{2})$']          = 'menus/menus_admin/dispatcher/list_menu/$1';
$route['^dashboard/menu-admin$']            = 'menus/menus_admin/dispatcher/list_backend_menu/vi';
$route['^dashboard/menu-admin/(\w{2})$']    = 'menus/menus_admin/dispatcher/list_backend_menu/$1';
$route['^dashboard/menu/add$']              = 'menus/menus_admin/dispatcher/add_menu';
$route['^dashboard/menu/edit$']             = 'menus/menus_admin/dispatcher/edit_menu';
$route['^dashboard/menu/delete$']           = 'menus/menus_admin/dispatcher/delete_menu';
$route['^dashboard/menu/save-cache$']       = 'menus/menus_admin/save_cache_menu';

$route['^menus/sort$']                  = 'menus/menus_admin/sort_menus';
$route['^menus/active$']                = 'menus/menus_admin/update_menu_active';
/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/
