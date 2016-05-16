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
        $this->addScript('watch.js');
    }
    
    public function index($id = 1){
        $this->data['id'] = $id;
        $this->display('watch/index', $this->data);
    }
    
    public function getLinks(){
        echo $this->Watch_model->getLinks();
    }
    
    public function getLocation(){
        echo $this->Watch_model->getLocation();
    }
    
    public function markWatched(){
        //echo $this->Watch_model->markWatched();
        if($this->Watch_model->stepVideo('up')){
            echo 'Marked as watched! Reload to watch next episode.';
        }else{
            echo 'Unable to move to next episode.';
        }
    }
    
    public function nextEpisode(){
        //echo $this->Watch_model->nextEpisode();
        if($this->Watch_model->stepVideo('up')){
            echo 'Moving to next episode.';
        }else{
            echo 'Unable to move to next episode.';
        }
    }
    
    public function previousEpisode(){
        //echo $this->Watch_model->previousEpisode();
        if($this->Watch_model->stepVideo('down')){
            echo 'Moving to previous episode.';
        }else{
            echo 'Unable to move to previous episode.';
        }
    }
}
?>
