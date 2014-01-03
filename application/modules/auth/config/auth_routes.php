<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$route['^thoat$']                                   = 'auth/dispatcher/logout';
$route['^dang-nhap$']                               = 'auth/dispatcher/login';
$route['^([\w]+)/(dang-nhap|login)$']               = 'auth/dispatcher/login';
$route['lien-he']                                   = 'auth/dispatcher/contact';
$route['([\w]+)/(lien-he|contact)']                 = 'auth/dispatcher/contact';
$route['^quen-mat-khau$']                           = 'auth/dispatcher/forget_password';
$route['^([\w]+)/(quen-mat-khau|forget-password)$'] = 'auth/dispatcher/forget_password';


/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
//$route['^dashboard$']                       = 'dashboard/dispatcher/list_dashboard';
$route['^doi-mat-khau$']                    = 'auth/auth_admin/dispatcher/change_password';
$route['^dashboard/users/change-password$'] = 'auth/auth_admin/dispatcher/change_password';
/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/
