<?php

/**
 * The model for the watch page
 * 
 * @author Shawn Contant <shawnc366@gmail.com>
 */

class Watch_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function getURL(){
        $this->db->select('url');
        return $this->db->get('series')->row_array()['url'];
    }
}



?>