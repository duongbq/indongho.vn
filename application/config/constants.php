<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Mặc định của duongbq */
define('DEFAULT_ADMIN_KEYWORDS',      'duongbq');
define('DEFAULT_ADMIN_DESCRIPTION',   'Hệ quản trị thông tin duongbq');
define('DEFAULT_ADMIN_TITLE',         'Quản trị hệ thống');
define('DEFAULT_ADMIN_TITLE_SUFFIX',  ' | duongbq');

define('DEFAULT_TITLE_SUFFIX',  ' | indongho.vn');
define('DEFAULT_CACHE_PREFIX',  'ip_');

define('CITY_ID',        1);

// operations permission
define('OPERATION_MANAGE',      2);
define('OPERATION_NEWS_MANAGE_CAT',  20);

define('OPERATION_ADMIN',  21);


define('ROLE_GUESS'     ,        -1);
define('ROLE_ADMINISTRATOR',      0);
define('ROLE_MANAGER',            2);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */