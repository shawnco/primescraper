<?php

/**
 * Controller for the main page
 * 
 * @author Shawn Contant <shawnc366@gmail.com> * 
 */

class Watch extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Watch_model');
        $this->data['title'] = 'Watch';
        $this->data['url'] = $this->Watch_model->getURL();
    }
    
    public function index($id = 1){
        $this->data['id'] = $id;
        $this->display('watch/index', $this->data);
    }
}
?>
