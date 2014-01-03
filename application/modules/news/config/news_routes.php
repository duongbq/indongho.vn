<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// FRONT-END

$route['^tim-kiem$']                        = 'news/dispatcher/list_news/1';
$route['^tim-kiem/trang-(\d+)$']            = 'news/dispatcher/list_news/$1';
$route['^en/search$']                       = 'news/dispatcher/list_news/1';
$route['^en/search/trang-(\d+)$']            = 'news/dispatcher/list_news/$1';

$route['^tin-tuc$']                         = 'news/dispatcher/list_news/1/vi';
$route['^tin-tuc/trang-(\d+)$']             = 'news/dispatcher/list_news/$1/vi';

$route['^(\w{2})/(tin-tuc|news)$']                         = 'news/dispatcher/list_news/1/$1';
$route['^(\w{2})/(tin-tuc|news)/trang-(\d+)$']             = 'news/dispatcher/list_news/$3/$1';

$route['^([\w\d-]+)-n(\d+)$']                     = 'news/dispatcher/list_news_by_cat/vi/$2/1';
$route['^([\w\d-]+)-n(\d+)/trang-(\d+)$']         = 'news/dispatcher/list_news_by_cat/vi/$2/$3';

$route['^([\w]+)/[\w\d-]+-n(\d+)$']                     = 'news/dispatcher/list_news_by_cat/$1/$2/1';
$route['^([\w]+)/[\w\d-]+-n(\d+)/trang-(\d+)$']         = 'news/dispatcher/list_news_by_cat/$1/$2/$3';
//$route['^tim-kiem/tin-tuc$']                        = 'news/dispatcher/list_news';
//$route['^tim-kiem/tin-tuc/trang-(\d+)$']            = 'news/dispatcher/list_news/$1';
//$route['^tin-tuc/[\w\d-]+-n(\d+)-(\d+)$']           = 'news/dispatcher/news_detail/$1/$2';
$route['^([\w\d-]+)/[\w\d-]+-n(\d+)-(\d+)$']            = 'news/dispatcher/news_detail/vi/$2/$3';
$route['^([\w]+)/[\w\d-]+/[\w\d-]+-n(\d+)-(\d+)$']      = 'news/dispatcher/news_detail/$1/$2/$3';

/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
//// BACK-END
// news
$route['^dashboard/news/add$']                      = 'news/news_admin/dispatcher/add_news';
$route['^dashboard/news/edit$']                     = 'news/news_admin/dispatcher/edit_news';
$route['^dashboard/news/delete$']                   = 'news/news_admin/delete_news';
// categories
$route['^dashboard/news/categories/add$']           = 'news/news_cat/dispatcher/add_cat/$1';
$route['^dashboard/news/categories/edit$']          = 'news/news_cat/dispatcher/edit_cat/$1';
$route['^dashboard/news/categories/delete$']        = 'news/news_cat/dispatcher/delete_cat';

$route['^dashboard/news/categories$']               = 'news/news_cat/dispatcher/list_cat/vi/1';
$route['^dashboard/news/categories/([\w]+)$']               = 'news/news_cat/dispatcher/list_cat/$1/1';
$route['^dashboard/news/categories/([\w]+)/page-(\d+)$']    = 'news/news_cat/dispatcher/list_cat/$1/$2';

$route['^dashboard/news$']                          = 'news/news_admin/dispatcher/list_news/vi/1';
$route['^dashboard/news/([\w]+)$']                  = 'news/news_admin/dispatcher/list_news/$1/1';
$route['^dashboard/news/([\w]+)/page-(\d+)$']       = 'news/news_admin/dispatcher/list_news/$1/$2';


// ajax 
$route['^get_categories_by_lang$']                  = 'news/news_cat/get_categories_by_lang';
/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/