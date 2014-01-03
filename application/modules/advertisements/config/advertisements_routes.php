<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['^dashboard/upload_adv$']            = 'advertisements/advertisements_admin/dispatcher/upload_adv';
$route['^dashboard/advertisements/slide$']  = 'advertisements/advertisements_admin/dispatcher/list_advertisements/1/vi';
$route['^dashboard/advertisements/service$'] = 'advertisements/advertisements_admin/dispatcher/list_advertisements/2/vi';
$route['^dashboard/advertisements/partners$']   = 'advertisements/advertisements_admin/dispatcher/list_advertisements/3/vi';

$route['^dashboard/advertisements/slide/(\w{2})$']  = 'advertisements/advertisements_admin/dispatcher/list_advertisements/1/$1';
$route['^dashboard/advertisements/service/(\w{2})$'] = 'advertisements/advertisements_admin/dispatcher/list_advertisements/2/$1';
$route['^dashboard/advertisements/partners/(\w{2})$']   = 'advertisements/advertisements_admin/dispatcher/list_advertisements/3/$1';

//ajax upload ảnh cho advertisement
$route['^upload_advertisement_images$'] = 'advertisements/advertisements_admin/ajax_upload_advertisement_images';
$route['^advertisements/sort']          = 'advertisements/advertisements_admin/sort_advertisement';
$route['^advertisements/edit_link']     = 'advertisements/advertisements_admin/edit_link';
$route['^advertisements/edit_title']    = 'advertisements/advertisements_admin/edit_title';
$route['^advertisements/change_adv_status'] = 'advertisements/advertisements_admin/change_adv_status';
$route['^advertisements/delete_adv']     = 'advertisements/advertisements_admin/delete_adv';


$route['^du-an$']                        = 'advertisements/advertisements/dispatcher/list_project';
$route['^(\w{2})/(du-an|projects)$']    = 'advertisements/advertisements/dispatcher/list_project';