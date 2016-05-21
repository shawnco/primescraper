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
                'preference' => ''
            );
        }else{
            $output = array(
                'result' => 'success',
                'message' => 'Source added.',
                'domain' => $domain,
                'type' => $type,
                'preference' => $maxPref
            );            
        }
        return json_encode($output);
    }
    
    public function resort($data){
        foreach($data as $k => $v){
            $this->db->where('domain', $v);
            $this->db->update('sources', array('preference' => $k+1));
        }
        
        // Now their their new preferences to make sure all is right.
        $this->db->select('preference');
        $this->db->order_by('preference');
        return json_encode($this->db->get('sources')->result_array());
    }
    
    public function deleteSource($source, $preference){
        $this->db->where('domain', $source);
        $this->db->delete('sources');
        
        // Promote all of the lower ranking preferences
        $this->db->select('domain, preference');
        $this->db->where('preference >', $preference);
        $promotable = $this->db->get('sources')->result_array();
        foreach($promotable as $row){
            $data = array(
                'preference' => $row['preference'] - 1
            );
            $this->db->where('domain', $row['domain']);
            $this->db->update('sources', $data);
        }
        
        // Return the new preferences
        $this->db->select('preference');
        $this->db->order_by('preference');
        $result = $this->db->get('sources')->result_array();
        return json_encode($result);
        
    }
    
    public function updateSource($source, $type, $preference){
        $data = array(
            'domain' => $source,
            'type' => $type
        );
        $this->db->where('preference', $preference);
        $this->db->update('sources', $data);
        $this->db->select('domain, type');
        $this->db->where('preference', $preference);
        return json_encode($this->db->get('sources')->result_array());
    }
}
?>
