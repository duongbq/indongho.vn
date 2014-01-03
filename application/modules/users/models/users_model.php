<?php
class Users_Model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }
    private function _set_where_conditions($paras = array())
    {
        if (isset($paras['role_id']))
            $this->db->where('roles_id', $paras['role_id']);

        if (isset($paras['user_id']))
            $this->db->where('id', $paras['user_id']);

        if (isset($paras['username']))
            $this->db->where('username', $paras['username']);

        if (isset($paras['email']))
            $this->db->where('email', $paras['email']);

        if (isset($paras['active']) && $paras['active'] != '')
            $this->db->where('active', $paras['active']);

         if (isset($paras['user_id_except']))
            $this->db->where('id <>' . $paras['user_id_except']);

        if (isset($paras['search']))
        {
            $where  = "(    fullname    like'%" . $paras['search'] . "%'";
            $where .= " or  email       like'%" . $paras['search'] . "%'";
            $where .= " or  address     like'%" . $paras['search'] . "%'";
            $where .= " or  phone1      like'%" . $paras['search'] . "%'";
            $where .= " or  phone2      like'%" . $paras['search'] . "%'";
            $where .= " or  username    like'%" . $paras['search'] . "%')";
            $this->db->where($where);
        }
    }
    function get_users($paras = array())
    {
        $this->_set_where_conditions($paras);

        if (isset($paras['order']))
            $this->db->order_by($paras['order']);
        else
            $this->db->order_by('alias_name');

        $query = $this->db->get('users');

        return $query->result();
    }

    function get_users_array($paras = array())
    {
        $users = $this->get_users($paras);
        $output = array();
        foreach($users as $user)
        {
            if (isset($paras['FULLNAME']))
                $output[$user->id] = $user->fullname;
            else
                $output[$user->id] = $user->alias_name;
        }
        return $output;
    }

    function get_users_combo($options = array())
    {
        // Default categories name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'users';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $users = $this->get_users($options); // added options 2011-03-11

        $data_options = array();

        if (isset($options['ALL']))
            $data_options[DEFAULT_COMBO_VALUE] = 'Tất cả';

        foreach($users as $user)
        {
            if (isset($options['FULL']))
                $data_options[$user->id] = $user->fullname;
            else
                $data_options[$user->id] = $user->alias_name;
        }

        if ( ! isset($options[$options['combo_name']]))
        {
            $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
        }
        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $options['extra']);
    }

    function get_roles($options = array())
    {
        return $this->db->get('roles')->result();
    }

    function get_user_possition_combo($options = array())
    {
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'role_id';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $roles = $this->get_roles();

        $data_options = array();

        foreach($roles as $role)
        {
            if ((int)$role->id === DEFAULT_COMBO_VALUE)
                $data_options[$role->id] = 'Tất cả';
            else
                $data_options[$role->id] = $role->role;
        }

        if ( ! isset($options[$options['combo_name']]))
        {
            $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
        }

        return form_dropdown(
                $options['combo_name'],
                $data_options,
                $options[$options['combo_name']],
                $options['extra']
                );
    }

    function get_user_status_combo($options = array())
    {
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'active';
        }

        $data_options = array();

        $data_options[DEFAULT_COMBO_VALUE] = 'Tất cả';
        $data_options[ACCOUNT_ACTIVE] = 'Đang công tác';
        $data_options[ACCOUNT_DEACTIVE] = 'Đã nghỉ việc';

        if ( ! isset($options[$options['combo_name']]))
        {
            $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
        }
        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']]);
    }

    function add_user($data = array())
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    function update_user($data = array())
    {
        if (isset($data['id']))
        {
            $this->db->where('users.id', $data['id']);
            $this->db->update('users', $data);
        }
    }

    function delete_user($params = array())
    {
        if (isset($params['account_id']))
        {
            //Xoa lich hen cua nv thi truong
            $this->db->where('schedules.directsale_id', $params['account_id']);
            $this->db->delete('schedules');
            //lich hen cua tu van
            $this->db->where('schedules.telesale_id', $params['account_id']);
            $this->db->delete('schedules');
            //Diem danh
            $this->db->where('timekeepers.user_id', $params['account_id']);
            $this->db->delete('timekeepers');

            $this->db->where('user_timekeeper.user_id', $params['account_id']);
            $this->db->delete('user_timekeeper');

            $this->db->where('users.id', $params['account_id']);
            $this->db->delete('users');

        }
    }

    /**
     * @author duongbq
     * @date 11-5-2011
     * Lấy tất cả user theo check box
     */

    function get_user_checkbox($options = array())
    {
        $options['user_id_except'] = $this->phpsession->get('user_id');
        $users = $this->get_users($options);

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $data_options = array();
        $check_box_array_from = array();
        foreach($users as $user)
        {
            if (isset($options['FULL']))
                $data_options[$user->id] = $user->fullname;
            else
                $data_options[$user->id] = $user->alias_name;

            $checkbox_name = 'users'. $user->id;

            $data = array(
            'name'        => $checkbox_name,
            'value'       => $user->id,
            'style'       => $options['extra']
            );

            $data['checked'] = ($options['selected_ids'][$checkbox_name] == 1) ? TRUE : FALSE;
            $check_box_array_from['checkbox_name'][] = form_checkbox($data) . $data_options[$user->id];
        }
        return $check_box_array_from['checkbox_name'];
    }

    function get_user_timekeeper($user_id)
    {
        $result = $this->db->select('morning_start, afternoon_start')
                           ->get_where('user_timekeeper',array('user_id' => $user_id));
        return $result->row_array();
    }

    function get_user_role_info($user_id)
    {
        $result = $this->db->select(array('users.id','roles.id as role_id'))
                ->join('roles', 'roles.id = users.roles_id', 'INNER')
                ->where(array('users.id' => $user_id))
                ->get('users');
        return $result->row_array();
    }

    function _fix_account_time_keepper($user_id){
        if(
            $user_id
            && $user_role = $this->get_user_role_info( $user_id )
        )
        {
            $data = $this->get_user_timekeeper( $user_id );
            if( empty($data) )
            {
                $this->db->insert('user_timekeeper', get_account_timekepper( $user_role['role_id'] ) + array( 'user_id' => $user_id ) );
            } else {
                if(
                        $data['morning_start'] == NULL
                    || $data['afternoon_start'] == NULL 
                    || trim($data['afternoon_start']) == '00:00:00' 
                    || trim($data['morning_start']) == '00:00:00'
                )
                    $this->db->update('user_timekeeper', get_account_timekepper( $user_role['role_id'] ) , array( 'user_id' => $user_id ) );
            }
        }
    }
}
