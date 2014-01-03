<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// front end của page
$route['^([\w\d-]+)\.htm$']                         = 'pages/dispatcher/page_detail/$1/$2';
$route['^(\w{2})/([\w\d-]+)\.htm$']                 = 'pages/dispatcher/page_detail/$1/$2';


/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
// back end
$route['^dashboard/pages']                      = 'pages/pages_admin/dispatcher/list_pages/1';
$route['^dashboard/pages/page-(\d+)$']          = 'pages/pages_admin/dispatcher/list_pages/$1';
$route['^dashboard/pages/add$']                 = 'pages/pages_admin/dispatcher/add_page';
$route['^dashboard/pages/edit$']                = 'pages/pages_admin/dispatcher/edit_page';
$route['^dashboard/pages/delete$']              = 'pages/pages_admin/delete_page';
$route['^dashboard/pages/save-cache']           = 'pages/pages_admin/save_cache';
//ajax change page status
$route['change_page_status']                    = 'pages/pages_admin/process_page_status';
/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/