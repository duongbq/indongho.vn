<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//$route['^your-route$' = '';
$route['^dashboard/keywords$']            = 'realseo/realseo/dispatcher/list_keyword';
$route['^dashboard/keywords/add$']        = 'realseo/realseo/dispatcher/add_keyword';
$route['^dashboard/keywords/edit/(\d+)']  = 'realseo/realseo/dispatcher/edit_keyword/$1';
$route['^dashboard/keywords/delete/(\d+)']= 'realseo/realseo/delete_keyword/$1';