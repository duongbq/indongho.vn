<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
// back end
$route['^dashboard/system_config']              = 'configurations/configurations_admin/dispatcher/config';
$route['^dashboard/system_config/save-cache']   = 'configurations/configurations_admin/save_cache';

/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/