<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
//front end
$route['^y-kien-khach-hang']                        = 'feedbacks/feedbacks/dispatcher/send_feedback';

// back end
$route['^dashboard/feedbacks']                      = 'feedbacks/feedbacks_admin/dispatcher/list_feedbacks/1';
$route['^dashboard/feedbacks/page-(\d+)$']          = 'feedbacks/feedbacks_admin/dispatcher/list_feedbacks/$1';
$route['^dashboard/feedbacks/add$']                 = 'feedbacks/feedbacks_admin/dispatcher/add_feedback';
$route['^dashboard/feedbacks/edit$']                = 'feedbacks/feedbacks_admin/dispatcher/edit_feedback';
$route['^dashboard/feedbacks/delete$']              = 'feedbacks/feedbacks_admin/delete_feedback';

//ajax change feedback status
$route['change_feedback_status']                    = 'feedbacks/feedbacks_admin/process_feedback_status';
/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/