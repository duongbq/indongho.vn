<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//ajax
$route['^change_product_status$']           = 'products/products_admin/process_status';
$route['^remove_product_in_cart$']          = 'products/orders/remove_product_in_cart';
$route['^update_product_in_cart$']          = 'products/orders/update_product_in_cart';
$route['^get_district$']                    = 'products/orders/get_district';

$route['^gio-hang$']                        = 'products/orders/dispatcher/shopping_cart';
$route['^mua-hang/[\w\d-]+i(\d+)$']         = 'products/orders/add_to_cart/$1';
$route['^cam-on$']                          = 'products/orders/dispatcher/thank_you';

$route['^san-pham$']                        = 'products/dispatcher/list_products/vi/1';
$route['^san-pham/trang-(\d+)$']            = 'products/dispatcher/list_products/vi/$1';

$route['^tim-kiem$']                        = 'products/dispatcher/list_products/vi/1';
$route['^tim-kiem/trang-(\d+)$']            = 'products/dispatcher/list_products/vi/$1';

$route['^(\w{2})/(san-pham|products)$']     = 'products/dispatcher/list_products/$1/1';
$route['^(\w{2})/(san-pham|products)/trang-(\d+)$']     = 'products/dispatcher/list_products/$1/$3';

// chi tiết sản phẩm
$route['^([\w\d-]+)/[\w\d-]+i(\d+)$']               = 'products/dispatcher/view_detail/vi/$1/$2/';
$route['^(\w{2})/([\w\d-]+)/[\w\d-]+i(\d+)$']       = 'products/dispatcher/view_detail/$1/$2/$3/';

// trang sản phẩm lọc theo danh mục sản phẩm
$route['^[\w\d-]+-c(\d+)$']                 = 'products/dispatcher/list_products_by_cat/-1/$1';
$route['^[\w\d-]+-c(\d+)/trang-(\d+)$']     = 'products/dispatcher/list_products_by_cat/-1/$1/$2';

$route['^([\w\d-]+)/[\w\d-]+-c(\d+)$']             = 'products/dispatcher/list_products_by_cat/$1/$2';
$route['^([\w\d-]+)/[\w\d-]+-c(\d+)/trang-(\d+)$'] = 'products/dispatcher/list_products_by_cat/$1/$2/$3';

//Lấy danh sách sản phẩm liên quan AJAX
$route['^get_products_related_ajax$']              = 'products/get_products_same_cat_ajax';




/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
// Quản lý sản phẩm
$route['^dashboard/products/add$']                      = 'products/products_admin/dispatcher/add_product';
$route['^dashboard/products/edit/(\d+)$']               = 'products/products_admin/dispatcher/edit_product/$1';
$route['^dashboard/products/delete/(\d+)$']             = 'products/products_admin/dispatcher/delete_product/$1';
$route['^dashboard/products/up/(\d+)$']                 = 'products/products_admin/dispatcher/up_product/$1';
// Ajax kéo, thả, xóa hình ảnh khi đăng sản phẩm
$route['^upload_products_images$']            = 'products/products_admin/ajax_upload_products_image';
$route['^get_products_images$']               = 'products/products_admin/get_products_images';
$route['^sort_products_images$']              = 'products/products_admin/sort_products_image';
$route['^delete_products_images$']            = 'products/products_admin/delete_products_image';
$route['^products_categories/sort']           = 'products/categories_admin/sort_categories';


// Quản lý danh mục sản phẩm
$route['^dashboard/products/categories/add$']           = 'products/categories_admin/dispatcher/add_categories';
$route['^dashboard/products/categories/edit$']          = 'products/categories_admin/dispatcher/edit_categories';
$route['^dashboard/products/categories/delete$']        = 'products/categories_admin/dispatcher/delete_categories';

$route['^dashboard/products/categories$']               = 'products/categories_admin/dispatcher/list_categories/vi';
$route['^dashboard/products/categories/([\w]+)$']       = 'products/categories_admin/dispatcher/list_categories/$1';

$route['^dashboard$']                                   = 'products/products_admin/dispatcher/list_products/vi/1';
$route['^dashboard/products$']                          = 'products/products_admin/dispatcher/list_products/vi/1';
$route['^dashboard/products/([\w]+)$']                  = 'products/products_admin/dispatcher/list_products/$1/1';
$route['^dashboard/products/([\w]+)/page-(\d+)$']       = 'products/products_admin/dispatcher/list_products/$1/$2';

$route['^get_products_categories_by_lang$']            = 'products/categories_admin/get_products_categories_by_lang';
/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/