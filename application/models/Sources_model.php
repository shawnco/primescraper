<?php

/**
 * The model for video source information
 */

class Sources_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function getSources(){
        $this->db->select('domain, preference, type');
        $this->db->order_by('preference');
        $result = $this->db->get('sources')->result_array();
        if(count($result) < 1){
            return FALSE;
        }else{
            return $result;
        }
    }
    
    public function addSource($domain, $type){
        // By default, new sources have lowest priority
        $this->db->select_max('preference');
        $result = $this->db->get('sources')->row_array();
        if(count($result) < 1){
            $maxPref = 1;
        }else{
            $maxPref = $result['preference'] + 1;
        }
        $data = array(
            'domain' => $domain,
            'preference' => $maxPref,
            'type' => $type
        );
        $this->db->insert('sources', $data);
        if($this->db->affected_rows() < 1){
            $output = array(
                'result' => 'error',
                'message' => 'Source was not added.',
                'domain' => '',
                'type' => '',
            );
        }else{
            $output = array(
                'result' => 'success',
                'message' => 'Source added.',
                'domain' => $domain,
                'type' => $type,
            );            
        }
        return json_encode($output);
    }
}
?>
