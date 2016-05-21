<?php

/**
 * Controller for the sources page
 * 
 * @author Shawn Contant <shawnc366@gmail.com>
 */

class Sources extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Sources_model');
        $this->load->helper('form');
        $this->addScript('sources.js');
        $this->data['title'] = 'Sources';
        $this->data['sources'] = $this->Sources_model->getSources();
    }
    
    public function index(){
        $this->display('sources/index', $this->data);
    }
    
    public function addSource(){
        $domain = $this->input->post('domain');
        $type = $this->input->post('type');
        echo $this->Sources_model->addSource($domain, $type);
    }
    
    public function resort(){
        $data = $this->input->post('data');
        echo $this->Sources_model->resort($data);
    }
    
    public function deleteSource(){
        $source = $this->input->post('source');
        $preference = $this->input->post('preference');
        echo $this->Sources_model->deleteSource($source, $preference);
    }
    
    public function updateSource(){
        $source = $this->input->post('source');
        $type = $this->input->post('type');
        $preference = $this->input->post('preference');
        echo $this->Sources_model->updateSource($source, $type, $preference);
    }
}
?>
