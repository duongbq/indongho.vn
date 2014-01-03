<?php
class Auth extends MX_Controller
{
    private $_last_message = '';    // lưu giữ thông báo lỗi

    function __construct()
    {
        parent::__construct();
    }

    public function captcha()
    {
        create_security_captcha(array('context' => $this));
    }

    /**
     * Chuẩn bị layout, các phần dữ liệu cần thiết cho module này
     *
     * @param type $method
     * @param type $para1
     * @param type $para2
     */
    function dispatcher($method=NULL, $para1=NULL, $para2=NULL)
    {
        $main_content           = NULL;
        $layout                 = 'layout/content_layout';
        $lang                   = $this->_lang;
        $breadcrumbs            = '';
        $uri                    = '/' . $this->uri->uri_string();
        
        switch($method)
        {
            case 'login' :
                $main_content    = $this->login();
                break;
            case 'logout' :
                $main_content    = $this->logout();
                break;
            case 'contact' :
                $main_content    = $this->contact(array('lang' => $para1));
                $breadcrumbs     = modules::run('breadcrumbs/breadcrumbs_by_menus', array('uri' => $uri));
                break;
            case 'forget_password' :
                $main_content    = $this->forget_password(array('lang' => $para1));
                break;
        }
        $view_data = array();
        $view_data                      = modules::run('pages/pages/get_genaral_content', array('lang' => $lang, 'current_menu' => '/' . $this->uri->uri_string()));
        $view_data['breadcrumbs']       = $breadcrumbs;
        $view_data['main_content']      = $main_content;
        $view_data['title']             = $this->_title;
        $view_data['keywords']          = $this->_keywords;
        $view_data['description']       = $this->_description;

        $this->load->view($layout, $view_data);
    }
    /**
     * Kiểm tra xem đã đăng nhập chưa từ session
     *
     */
    function is_logged_in()
    {
        if ($this->phpsession->get('is_logged_in'))
            return TRUE;
        else
        {
            $this->phpsession->save('roles_id', ROLE_GUESS);
            return FALSE;
        }
    }

    /**
     * Lấy role
     *
     * @author Tuan Anh
     * @return <type>
     */
    function get_role_id()
    {
        $role = $this->phpsession->get('roles_id');
        if (empty($role) || $role ==='')
            $this->phpsession->save('roles_id', ROLE_GUESS);
        return $this->phpsession->get('roles_id');
    }

    /**
     * Đăng nhập
     *
     */
    function login($options = array())
    {   
        if ($this->is_logged_in()) redirect('/dashboard');
        $view_data = array();
        $options = array();

        if ($this->is_postback())
            if (!$this->_do_login())
                $options['error'] = $this->_last_message;
        if(isset($options['error'])) $view_data['options'] = $options;
        $view_data['breadcrumbs']   = modules::run('breadcrumbs/breadcrumbs_with_param', array( 0 => array('name' => __("IP_log_in") , 'uri' => '#')));
        $view_data['submit_uri']    = get_form_submit_by_lang($this->_lang, 'login_form');
        // prepare page header info.
        $this->_title               = __("IP_log_in") . DEFAULT_TITLE_SUFFIX;
        $this->_keywords            = $this->_title . ' ' . $this->_keywords;
        $this->_description         = $this->_description;
        // end.
        return $this->load->view('auth/login_form',$view_data, TRUE);
    }

    /**
     * Thoát khỏi hệ thống và xóa toàn bộ session
     */
    function logout()
    {
        $this->phpsession->clear();
        $this->cart->destroy();
        $this->phpsession->save('roles_id', ROLE_GUESS);

        redirect(get_base_url());
    }

    /**
     * Thực hiện việc đăng nhập
     *
     */
    private function _do_login()
    {
        $this->_last_message  = '';
        $options                    = array();

        $this->form_validation->set_rules('username', __("IP_user_name"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', __("IP_password"), 'trim|required|xss_clean');

        if ($this->form_validation->run())
        {
            $options['username']    = $this->input->post('username', TRUE);
            $options['password']    = $this->input->post('password', TRUE);

            $users = $this->users_model->get_users($options);

            $login = TRUE;
            if (count($users)==1)
            {
                $user = $users[0];

                if ((trim($options['username']) === trim($user->username))
                 && (md5(trim($options['password'])) === trim($user->password))
                 && ($user->active == 1))
                {

                    $this->phpsession->save('is_logged_in'  , TRUE);
                    $this->phpsession->save('username'      , $user->username);
                    $this->phpsession->save('fullname'      , $user->fullname);
                    $this->phpsession->save('email'         , $user->email);
                    $this->phpsession->save('user_id'       , $user->id);
                    $this->phpsession->save('roles_id'      , $user->roles_id);
                    redirect('/dashboard');
                    }
                else
                {
                    $login = FALSE;
                }
            }
            else
            {
                $login = FALSE;
            }

            if ( !$login)
            {
                $this->_last_message = '<p>' . __('IP_login_failed') . '</p>';
                return FALSE;
            }
        }
        $this->_last_message = validation_errors();
        return FALSE;
    }

    private function _send_new_password_email($options = array())
    {
        $this->load->library('email');

        $title      = TITLE_EMAIL . ' - Khoi phuc lai mat khau';
        $message    = $this->load->view('forget_password_email', $options, TRUE);

    $this->email->from(EMAIL_NO_REPLY, TITLE_EMAIL);
        $this->email->subject($title);
        $this->email->message($message);
        $this->email->to($options['email']);
        $this->email->send();
    }

    public function forget_password()
    {
        if ($this->is_logged_in()) redirect('/dashboard/pages');

        $options = array();
        $view_data = array();
        if ($this->is_postback())
            if (!$this->_process_forget_password())
                $options['error'] = $this->_last_message;
            else
                $options['succeed'] = $this->_last_message;
        
        // prepare page header info.
        $this->_title       = __('IP_forget_password') . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $this->_title . ' ' . $this->_keywords;
        $this->_description = $this->_description;
        // end.
        
        $view_data['submit_uri']  = get_form_submit_by_lang($this->_lang, 'forget_password_form'); 
        $view_data['breadcrumbs'] = modules::run('breadcrumbs/breadcrumbs_with_param', array( 0 => array('name' => __('IP_forget_password') , 'uri' => '#')));
        return $this->load->view('auth/forget_password_form',$view_data + array('options' => $options), TRUE);
    }

    private function _process_forget_password()
    {
        $this->_last_message  = '';
        $options                    = array();

        $this->form_validation->set_rules('username', __('IP_user_name'), 'trim|required|xss_clean|min_length[5]|matches_pattern[@{5,}]');
        $this->form_validation->set_rules('email', __('IP_email'), 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('security_code', __('IP_capcha'), 'trim|required|matches_value[' . $this->phpsession->get('captcha') . ']|xss_clean');
        if ($this->form_validation->run())
        {
            $options['username']    = $this->input->post('username', TRUE);
            $options['email']       = $this->input->post('email', TRUE);

            $user = $this->users_model->get_users($options);
            $ok = TRUE;
            if (count($user) > 0)
            {
                if ((my_trim($options['email'])=== my_trim($user[0]->email))
                 && (my_trim($options['username'])=== my_trim($user[0]->username))
                 && ($user[0]->active == 1))
                {
                    $new_password               = substr(md5(date('YmdHis') . $options['email']), 0, 6);
                    // update passsword mới và gửi email cho người dùng
                    $options['id']              = $user[0]->id;
                    $options['new_password']    = md5($new_password);

                    $this->users_model->update_user(array('id' => $options['id'], 'password' => $options['new_password']));
                    $this->_last_message = '<p>' . __("IP_get_password_success_message") . '</p>';
                    // Gửi email
                    $this->_send_new_password_email(array('fullname' => $user[0]->fullname, 'username' => $user[0]->username, 'email' => $user[0]->email, 'password' => $new_password));

                    return TRUE;
                }
                else
                {
                    $ok = FALSE;
                }
            }
            else
            {
                $ok = FALSE;
            }

            if ( !$ok)
            {
                $this->_last_message = '<p>' . __("IP_get_password_failed_message") . '</p>';
                return FALSE;
            }
        }
        $this->_last_message = validation_errors();
        return FALSE;
    }

    public function has_permission($options = array())
    {
        $role_id            = $this->get_role_id();
        $has_permission     = FALSE;

        switch($options['operation'])
        {
            case OPERATION_MANAGE  :                if (in_array($role_id, array(ROLE_ADMINISTRATOR, ROLE_MANAGER))) $has_permission = TRUE; break;
            case OPERATION_ADMIN   :                if (in_array($role_id, array(ROLE_ADMINISTRATOR))) $has_permission = TRUE; break;
        }
        
        return $has_permission;
    }

    function contact($options = array())
    {
        $view_data = array();
        if ($this->is_postback())
            if (!$this->_send_contact())
                $options['error'] = $this->_last_message;
            else
                $options['succeed'] = $this->_last_message;
        if(isset($options['error']) || isset($options['succeed'])) $view_data['options'] = $options;
        
        $view_data['breadcrumbs'] = modules::run('breadcrumbs/breadcrumbs_with_param', array( 0 => array('name' => __("IP_contact_title") , 'uri' => '#')));
        $view_data['submit_uri'] = get_form_submit_by_lang($this->_lang, 'contact_form');
        
        // prepare page header info.
        $this->_title   = __("IP_contact_title") . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $this->_title . ' ' . $this->_keywords;
        $this->_description = $this->_description;
        // end.
        
        return $this->load->view('auth/contact_form', $view_data, TRUE);
    }

    private function _send_contact()
    {
        $this->_last_message  = '';
        $options                    = array();

        $this->form_validation->set_rules('name', __("IP_fullname"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', __("IP_email"), 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('phone', __("IP_phone"), 'trim|required|xss_clean|is_numeric');
        $this->form_validation->set_rules('content', __("IP_content"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('security_code', __("IP_capcha"), 'trim|required|matches_value[' . $this->phpsession->get('captcha') . ']|xss_clean');

        if ($this->form_validation->run())
        {
            $this->load->library('email');
            $options['name'] = $this->input->post('name');
            $options['phone'] = $this->input->post('phone');
            $options['content'] = $this->input->post('content');
            $title      = 'Thư liên hệ của khách hàng '  . DOMAIN_NAME;
            $message    = $this->load->view('contact_content', $options, TRUE);

            $config        = modules::run('configurations/get_configuration', array('array' => TRUE));
            $contact_email = ($config['contact_email'] != '' && $config['contact_email'] != NULL) ? $config['contact_email'] : CONTACT_EMAIL;
            
            $this->email->from($this->input->post('email'), $options['name']);
            $this->email->subject($title);
            $this->email->message($message);
            $this->email->to($contact_email);
            if(!$this->email->send())
                echo $this->email->print_debugger();
            else
                $this->_last_message = '<p>Bạn đã gửi thư liên hệ thành công đến admin.</p>';
            return TRUE;
        }
        else
        {
            $this->_last_message = validation_errors();
            return FALSE;
        }
    }
}
?>
