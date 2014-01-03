<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$route['^thu-vien-anh']                    = 'albums/dispatcher/list_album';
//$route['^thu-vien-anh/[\w\d-]+-(\d+)']   = 'albums/dispatcher/album_detail/$1';
/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
$route['^albums/change_album_images_status$']   = 'albums/albums_admin/change_album_images_status';
$route['^albums/edit_link']                     = 'albums/albums_admin/edit_link';
$route['^albums/edit_title']                    = 'albums/albums_admin/edit_title';

$route['^dashboard/albums$']            = 'albums/albums_admin/dispatcher/list_albums';
$route['^dashboard/albums/add$']        = 'albums/albums_admin/dispatcher/add_album';
$route['^dashboard/albums/edit/(\d+)$'] = 'albums/albums_admin/dispatcher/edit_album/$1';
$route['^dashboard/albums/delete/(\d+)$'] = 'albums/albums_admin/delete_album/$1';
//
////ajax upload ảnh cho album
$route['^upload_album_images$']             = 'albums/albums_admin/ajax_upload_album_images';
$route['^get_album_images']                 = 'albums/albums_admin/get_album_images';
$route['^albums/sort_album_image']          = 'albums/albums_admin/sort_album_images';
$route['^albums/delete_album_images']       = 'albums/albums_admin/delete_album_images';
$route['^albums/sort_album']                = 'albums/albums_admin/sort_album';
/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/