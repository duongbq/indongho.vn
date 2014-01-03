<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author duongbq
 */
class Dashboard extends MX_Controller {

    public function __construct() {
        
       if(modules::run('auth/is_logged_in')){
           redirect('dashboard/pages');
       } else {
           redirect(base_url());
       }
    }

}
