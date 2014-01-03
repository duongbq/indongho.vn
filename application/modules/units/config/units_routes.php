<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
// Quản lý sản phẩm
$route['^dashboard/units/add$']                      = 'units/dispatcher/add_unit';
$route['^dashboard/units/edit$']                     = 'units/dispatcher/edit_unit';
$route['^dashboard/units/delete$']                   = 'units/dispatcher/delete_unit';

$route['^dashboard/units$']                          = 'units/dispatcher/list_unit/';

/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/