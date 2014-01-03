<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['libraries']  = array();
$autoload['helper']     = array('cookie', 'commons',);
$autoload['plugin']     = array();
$autoload['config']     = array();
$autoload['language']   = array();
$autoload['model']      = array('products_model', 
                                'utility_model',
                                'products_images_model',
                                'categories_model',
                                'city_model');