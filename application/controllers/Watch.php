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
        $this->data['location'] = $this->Watch_model->getLocation();
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
        $result = $this->Watch_model->stepVideo('up');
        if($result === END_OF_SERIES){
            echo 'End of series reached.';
        }else if($result === STEP_UNSUCCESSFUL){
            echo 'Unable to move to next episode.';
        }else{
            echo 'Marked as watched! Reload to watch next episode.';
        }
    }
    
    public function unmarkWatched(){
        $result = $this->Watch_model->stepVideo('down');
        if($result == START_OF_SERIES){
            echo 'First episode reached.';
        }else if($result == STEP_UNSUCCESSFUL){
            echo 'Unable to mark as unwatched.';
        }else{
            echo 'Episode unmarked as watched!';
        }
    }
    
    public function nextEpisode(){
        $result = $this->Watch_model->stepVideo('up');
        if($result === END_OF_SERIES){
            echo 'Last episode reached.';
        }else if($result === STEP_UNSUCCESSFUL){
            echo 'Unable to move to next episode.';
        }else{
            echo 'Moving to the next episode.';
        }        
    }
    
    public function previousEpisode(){
        $result = $this->Watch_model->stepVideo('down');
        if($result === START_OF_SERIES){
            echo 'First episode reached.';
        }else if($result === STEP_UNSUCCESSFUL){
            echo 'Unable to move to previous episode.';
        }else{
            echo 'Moving to the previous episode.';
        } 
    }
}
?>
