<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Format giá tiền theo định dạng của VN
 *
 * @author Tuấn Anh
 * @date   2011-05-02
 * @param type $number
 * @param type $currency
 * @param type $show_zero
 * @return type
 */
function get_vndate_string($input) {
    if (empty($input))
        return $input;

    $today = strtotime(date('Ymd H:i:s'));
    if (!is_numeric($input))
        $input = strtotime($input);
    // Nếu tin được đăng trong 3 ngày gần nhất thì hiện màu đỏ
    if (date("Ymd", $input) >= date("Ymd", $today - 60 * 60 * 24 * 2)) {
        if (date("Ymd", $input) == date("Ymd", $today))
            return '<span class="red">' . date("H:i", $input) . '</span>';
        else if (date("Ymd", $input) == date("Ymd", $today - 60 * 60 * 24))
            return '<span class="green">'. __('IP_yesterday') .'</span>';
        else
            return '<span class="blue">'. __('IP_2_days_ago') .'</span>';
    }
    // Nếu tin đăng trong năm hiện tại thì hiện tháng và ngày
    if (date("Y", $input) == date("Y", $today)) {
        return date("d/m", $input);
    }
    // Các năm khác thì hiện đầy đủ
    else {
        return date("d/m/y", $input);
    }
}

function convert_date_to_format_sql($date) {
    $date = str_replace('/', '-', $date);
    $day = date('d', strtotime($date));
    $month = date('m', strtotime($date));
    $year = date('Y', strtotime($date));
    return $year . '-' . $month . '-' . $day;
}

function create_security_captcha($options = array()) {
    if (!isset($options['length']))
        $options['length'] = 3;
    if (!isset($options['width']))
        $options['width'] = 60;
    if (!isset($options['height']))
        $options['height'] = 25;
    if (!isset($options['fontsize']))
        $options['fontsize'] = 15;

    $code = '';
    $charset = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';

    for ($i = 1, $cslen = strlen($charset); $i <= $options['length']; $i++) {
        $code .= $charset{rand(0, $cslen - 1)};
    }

    $img = ImageCreate($options['width'], $options['height']);

    $bg_color = ImageColorAllocate($img, 168, 140, 100);
    $text_color = ImageColorAllocate($img, 0, 0, 0);
    $grid_color = ImageColorAllocate($img, 168, 119, 0);
    // fill the background
    ImageFilledRectangle($img, 0, 0, $options['width'], $options['height'], $bg_color);

    $angle = ($options['length'] >= 6) ? rand(-($options['length'] - 6), ($options['length'] - 6)) : 0;
    $x_axis = rand(6, (360 / $options['length']) - 16);
    $y_axis = ($angle >= 0 ) ? rand($options['height'], $options['width']) : rand(6, $options['height']);
    // create the spiral background
    $theta = 1;
    $thetac = 7;
    $radius = 16;
    $circles = 20;
    $points = 32;

    for ($i = 0; $i < ($circles * $points) - 1; $i++) {
        $theta = $theta + $thetac;
        $rad = $radius * ($i / $points );
        $x = ($rad * cos($theta)) + $x_axis;
        $y = ($rad * sin($theta)) + $y_axis;
        $theta = $theta + $thetac;
        $rad1 = $radius * (($i + 1) / $points);
        $x1 = ($rad1 * cos($theta)) + $x_axis;
        $y1 = ($rad1 * sin($theta)) + $y_axis;
        imageline($img, $x, $y, $x1, $y1, $grid_color);
        $theta = $theta - $thetac;
    }
    // print the text
    $x = 10;
    $y = $options['fontsize'] + 2;

    for ($i = 0; $i < strlen($code); $i++) {
        $y = $options['height'] / 5;
        imagestring($img, $options['fontsize'], $x, $y, substr($code, $i, 1), $text_color);
        $x += ($options['fontsize']);
    }

    $options['context']->phpsession->save('captcha', $code);

    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Content-Type: image/jpeg");
    imagejpeg($img, null, 100);
}

function my_trim($string, $trim_all = false) {
    $str = '';
    $str = str_replace('&nbsp;', ' ', $string);

    if ($trim_all) {
        $str = str_replace(' ', '', $str);
        $str = str_replace(')', ') ', $str);
    } else {
        $str = trim($str);
        $str = preg_replace('/(\n+) /', '\1', $str);
        $str = preg_replace('/( )+/', ' ', $str);
    }
    return $str;
}

function remove_new_line($string) {
    $str = str_replace("\n", "&nbsp;", $string);

    return $str;
}

function prepare_pagination($options = array()) {
    $config = array();

    $config['total_rows'] = $options['total_rows'];
    $config['per_page'] = $options['per_page'];
    $config['offset'] = $options['offset'];
    $config['num_links'] = PAGINATION_NUM_LINKS;
    $config['first_link'] = '««';
    $config['prev_link'] = '«';
    $config['next_link'] = '»';
    $config['last_link'] = '»»';
    $config['js_function'] = $options['js_function'];

    return $config;
}

function get_uri_product($product_name = '', $id = 0) {
    $title = $product_name;
//    $today = dechex((int)date('His'));
//    $title .= ' ' . $today . 'i' . $id;
    $title .= ' ' . 'i' . $id;
    $title = url_title($title, 'dash', TRUE);
    return $title;
}


function shorten_str($str, $len, $suffix = '..') {
    if (mb_strlen(trim($str)) > $len)
        $str = mb_substr(trim($str), 0, $len) . $suffix;
    return $str;
}

function genarate_tags($tags = '', $key = '') {
    $str = '';
    $tags = explode(',', $tags);
    foreach ($tags as $tag) {
        $tag_url = str_replace(' ', '+', trim($tag));
        $str .='<a href="/tim-kiem/' . $key . '?q=' . $tag_url . '">' . $tag . '</a>';
    }
    return $str;
}

function get_short_description($input, $postion) {
    if (strlen($input) <= $postion)
        return $input;
    $output = substr($input, 0, $postion);
//    $output = substr($output,0,strrpos($output,' '));
    return $output . '...';
}

function get_date($date = '') {
    $date = str_replace('/', '-', $date);
    if ($date != '' && $date != NULL)
        return date('d/m/Y', strtotime($date));
    else
        return '';
}

function get_unit_from_price($price, $currency = UNIT_VND)
{
    $price_text = '';
    $unit       = '';

    if ($currency==UNIT_VND)
    {
        if ($price >= ONE_BILLION)
        {
            $price_text = number_format($price / ONE_BILLION, 2, ".", "");
            $unit = ONE_BILLION;
        }
        else if ($price >= ONE_MILLION)
        {
            $price_text = number_format($price / ONE_MILLION, 2, ".", "");
            $unit = ONE_MILLION;
        }
        else if ($price >= ONE_THOUSAND)
        {
            $price_text = number_format($price / ONE_THOUSAND, 2, ".", "");
            $unit = ONE_THOUSAND;
        }
        else
        {
            $price_text = 0;
            $unit = ONE_THOUSAND;
        }
    }
    return array('price' => $price_text, 'unit' => $unit);
}

function get_price_in_vnd($number, $currency = UNIT_VND, $show_zero = NOT_SHOW_ZERO)
{
    if ($number > 0)
        $text = number_format($number, 0, ",", ".");
    else
        $text = "";

    if ($currency==UNIT_USD)
    {
        if ($text != "")
            $text = "$" . $text;
    }

    if ($text == "")
        $text = $show_zero ? "0" : "Liên hệ";

    return $text;
}

function get_full_price_in_vnd($number)
{
    if ($number > 0)
        $text = number_format($number, 0, ",", ".");
    else
        $text = 0;

    return $text;
}

if ( ! function_exists('get_language'))
{
    function language_array()
    {
        $lang_array = array(
            array('short_lang' => 'vi', 'full_lang' => 'vietnamese', 'lang' => 'Tiếng Việt'),
            array('short_lang' => 'en', 'full_lang' => 'english', 'lang' => 'Tiếng Anh'),
//            array('short_lang' => 'cn', 'full_lang' => 'chinese', 'lang' => 'Tiếng Trung'),
            );
        return $lang_array;
    }
    
}

function switch_language($param = '')
{
    $langs = language_array();
    foreach($langs as $lang)
    {
        if($lang['short_lang'] == $param)
            return $param;
    }
    return 'vi';
}

if ( ! function_exists('get_language'))
{
    function get_language($lg = FALSE)
    {
        $CI     = & get_instance();
        $lang   = switch_language($CI->uri->segment(1));
        
        $langs = language_array();
        $lang_array = array();
        foreach($langs as $_lang)
        {
            $lang_array[$_lang['short_lang']] = $_lang['full_lang'];
        }
        $CI->config->set_item('language', $lang_array[$lang]);
        $CI->lang->load('ip', $lang_array[$lang]);
        return $lang;
    }
}

// this function for get text by key in currently language
if ( ! function_exists('__'))
{
    function __($line, $id = '')
    {
            $CI =& get_instance();
            $line = $CI->lang->line($line);
            if ($id != '')
            {
                    $line = '<label for="'.$id.'">'.$line."</label>";
            }
            return $line;
    }
}

// this function for get base url in currently language
if ( ! function_exists('get_base_url'))
{
    function get_base_url($lang = '')
    {
        if($lang == '')
        {
            $CI         = & get_instance();
            $lang       = switch_language($CI->uri->segment(1));

            $base_url   = $lang == 'vi' ? base_url() : base_url() . $lang . '/';
            return $base_url;
        }
        else
        {
            $base_url   = $lang == 'vi' ? base_url() : base_url() . $lang . '/';
            return $base_url;
        }
    }
}


if ( ! function_exists('get_form_submit_by_lang'))
{
    function get_form_submit_by_lang($lang='vi', $form='')
    {
        $array_from     = array(
            'contact_form'          => array('vi' => 'lien-he', 'en' => 'contact', 'cn' => 'contact'),
            'login_form'            => array('vi' => 'dang-nhap', 'en' => 'login', 'cn' => 'login'),
            'forget_password_form'  => array('vi' => 'quen-mat-khau', 'en' => 'forget-password', 'cn' => 'forget-password'),
            'member_registry_form'  => array('vi' => 'dang-ky-hoi-vien', 'en' => 'member_registry'),
            );
        $output = get_base_url() . $array_from[$form][$lang];
        return $output;
    }
}

if(!function_exists('get_url_by_lang'))
{
    function get_url_by_lang($lang='vi', $url='', $short_url=FALSE)
    {
        $array_from     = array(
            'news'          => array('vi' => 'tin-tuc', 'en' => 'news', 'cn' => 'news' ),
            'search'        => array('vi' => 'tim-kiem', 'en' => 'search'),
            'introduction'  => array('vi' => 'gioi-thieu.htm', 'en' => 'introduction.htm'),
            'footer'        => array('vi' => 'chan-trang', 'en' => 'footer'),
            'products'        => array('vi' => 'san-pham', 'en' => 'products'),
            );
        if($short_url)
            $output = $lang != 'vi' ? '/' . $lang . '/'  . $array_from[$url][$lang] : '/'  . $array_from[$url][$lang];
        else
            $output = get_base_url() . $array_from[$url][$lang];
        return $output;
    }
}
if(!function_exists('add_tags'))
{
    function add_tags($string = '')
    {
        $CI =& get_instance();
        $CI->load->model('realseo/realseo_model');
        $keywords = $CI->realseo_model->get_array_keywords();

        foreach($keywords as $index => $keyword)
        {
            $string = preg_replace('/'. $keyword[0] .'/i', '{#' . $index . '}', $string);
        }

        foreach($keywords as $index => $keyword)
        {
            $title = $keyword[2] != '' ? $keyword[2] : $keyword[0];
            $string = str_replace('{#' . $index . '}', anchor($keyword[1], $keyword[0], array('title' => $title)), $string);

        }
        return $string;
    }
}

?>
