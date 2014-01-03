<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ADMIN_PRODUCT_PER_PAGE' ,20);
define('ONE_BILLION',           1000000000);
define('ONE_MILLION',           1000000);
define('ONE_THOUSAND',          1000);
define('ONE_USD',               1);
define('UNIT_VND',              0);
define('UNIT_USD',              1);
define('SHOW_ZERO',             TRUE);
define('NOT_SHOW_ZERO',         FALSE);

define('ACTIVE_PRODUCT',        1);
define('INACTIVE_PRODUCT',      0);


define('IS_SPECIAL_PRODUCT',    1);
define('IS_NOT_SPECIAL_PRODUCT',0);

define('IS_TAX',    1);
define('IS_NOT_TAX',0);



define('PRODUCT_PER_PAGE'      ,12);
define('PRODUCT_NAME_MAXLENGTH',17);
define('PRODUCT_NAME_MAXLENGTH_HOMEPAGE',17);
define('PRODUCT_NAME_MAXLENGTH_RELATED',50);
define('DESCRIPTION_MAXLENGTH',280);
define('LIMIT_RELATED_PRODUCT', 12);
define('LIMIT_RELATED_PRODUCT_PAGE', 5); // set value( 0 ) : page unlimit
define('LIMIT_LASTEST_PRODUCT', 12);
define('LIMIT_THE_MOST_VIEWED_PRODUCT', 12);
define('LIMIT_THE_MOST_BOUGHT_PRODUCT', 12);
define('LIMIT_HIGHLIGHT_PRODUCT', 12);
define('LIMIT_HIGHLIGHT_CATEGORIES', 3);

//==========================================================
define('NEW_ORDER'      , 0);
define('ILLUSIVE_ORDER' , 2);
define('PAID_ORDER'     , 1);


define('SOLD_OUT'       , 2);
define('STOCKING'       , 1);
define('COMING_SOON'    , 3);


define('ORDER_PER_PAGE'    , 20);