<?php

/**
 * The controller for the series page.
 * 
 * @author Shawn Contant <shawnc366@gmail.com>
 */

class Series extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Series_model');
        $this->data['title'] = 'Series';
        $this->data['series'] = $this->Series_model->getCurrentURL();
        $this->load->helper('form');
        $this->addScript('series.js');
    }
    
    public function index(){
        $this->display('series/index', $this->data);
    }
    
    public function search(){
        $url = $this->input->post('url');
        $url = str_replace(' ', '+', $url);
        echo $this->Series_model->search($url);
    }
    
    public function update(){
        $url = $this->input->post('url');
        echo $this->Series_model->update($url);
    }
}
?>
