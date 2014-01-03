<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Units extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('units_model');
//        $this->output->enable_profiler(TRUE);
    }
    
    function dispatcher($method='', $para1=NULL, $para2=NULL)
    {
        $layout             = 'duongbq/admin_layout';
        $lang               = switch_language($para2);
        switch ($method)
        {
            case 'list_unit':
                $main_content       = $this->list_unit(array('lang' => $lang));
                break;
            case 'edit_unit':
                $main_content       = $this->edit_unit(array('lang' => $lang));
                break;
            case 'add_unit':
                $main_content       = $this->add_unit(array('lang' => $lang));
            case 'delete_unit':
                $main_content       = $this->delete_unit();
                break;
        }

        $view_data                  = array();
        $view_data['url']           = isset($current_url) ? $current_url : '';
        $view_data['admin_menu']    = modules::run('menus/menus/get_dashboard_menus');
        $view_data['main_content']  = $main_content;
        // META data
        $view_data['title']         = $this->_title;

        $this->load->view($layout, $view_data);
    }
    
    function list_unit( $options = array() ) {
        
        $view_data                          = array();
        $view_data                          = $options;
        $view_data['units']                 = $this->units_model->get_units($options);
        
        if(isset($options['error'])) $view_data['options'] = $options;
        
        $this->_title                       = 'Quản lý đơn vị' . DEFAULT_TITLE_SUFFIX;
        
        return $this->load->view( 'units', $view_data, TRUE );
    }
    
    function get_unit_ajax(){
        if( $this->is_postback() && $this->input->post('is_ajax') && $id = $this->input->post('unit_id') ) {
            $unit = $this->units_model->get_units( array( 'id' => $id, 'array' => TRUE ) );
            if(!empty($unit))
                echo json_encode($unit);
            else
                echo '';
            exit();
        }
    }
    
    function add_unit( $options = array() ) {
        
        if( $this->is_postback() ) {
            
            if( ! $this->_do_add_unit() ) {
                
                $options['error'] = validation_errors();
                
                if( $this->input->post('is_ajax') ) {
                    
                    die( $this->load->view('duongbq/message', $options, TRUE));
                
                } else {
                    
                    $options['display_form']    = TRUE;
                    $options['submit_uri']      = '';
                    return $this->list_unit($options);
                    
                }
            } else {
                if( $this->input->post('is_ajax') ) {
                    die('OK'); 
                } else {
                    redirect('dashboard/units');
                }
            }
        }else{
            
        }
    }
    
    function edit_unit( $options = array() ) {
        
        if( $this->is_postback() ) {
            
            if( ! $this->_do_edit_unit() ) {
                
                $options['error'] = validation_errors();
                
                if( $this->input->post('is_ajax') ) {
                    
                    die( $this->load->view('duongbq/message', $options, TRUE ) );
                    
                } else {
                    
                    $options['display_form']    = TRUE;
                    $options['submit_uri']      = '';
                    return $this->list_unit($options);
                    
                }
            } else {
                if( $this->input->post('is_ajax') ) {
                    die('OK'); 
                } else {
                    redirect('dashboard/units');
                }
            }
        }
    }
    
    private function _do_add_unit() {
        
        $this->form_validation->set_rules( 'unit_name', 'Tên đơn vị', 'trim|required|xss_clean|max_length[256]' );
        
        if ( $this->form_validation->run() ) {
            $data = array( 'name'  => $this->input->post( 'unit_name' ) );
            $this->units_model->add_unit( $data );
            return TRUE;
        }else{
            return FALSE;
        } 
    }
    
    private function _do_edit_unit() {
        
        $this->form_validation->set_rules( 'unit_name', 'Tên đơn vị', 'trim|required|xss_clean|max_length[256]' );
        $this->form_validation->set_rules( 'unit_id', 'Mã đơn vị', 'trim|required|xss_clean|max_length[256]' );
        
        if ( $this->form_validation->run() ) {
            $data = array( 'name'  => $this->input->post( 'unit_name' ), 'id' => $this->input->post('unit_id') );
            $this->units_model->update_unit( $data );
            return TRUE;
        }else{
            return FALSE;
        } 
    }
    
    function delete_unit(){
        if( $this->is_postback() ) {
            if( $this->input->post('is_ajax') && $id = $this->input->post('unit_id') ) {
                $this->units_model->delete_unit($id);
            }
        }
    }

    function sort(){
        if( $this->is_postback() ) {
            $data = $this->input->post();
            if( isset( $data['sort'] ) && count( $data ) > 0 ) {
                
                $update_data = array();
                
                foreach ( $data['sort'] as $key => $value ) {
                    
                    $this->units_model->update_unit( array( 'id' => $value, 'position' => ( $key + 1 ) ) );
//                    $update_data[] = array(
//                        'id' => $value,
//                        'position' => $key + 1
//                    );
                }
//                $this->db->update_batch('units', $update_data, 'id');
            }
        }
    }
    
}
?>
