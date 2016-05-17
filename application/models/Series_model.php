<?php

/**
 * The model for the series page.
 * 
 * @author Shawn Contant <shawnc366@gmail.com>
 */

class Series_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function getCurrentURL(){
        $this->db->select('url');
        return $this->db->get('series')->row()->url;
    }
    
    public function search($url){
        $search = file_get_html('http://www.primewire.ag/index.php?search_keywords=' . $url . '&search_section=1');
        $output = array();
        foreach($search->find('.index_item') as $elem){
            $output[] = $elem->children[0]->href;
        }
        return json_encode($output);
    }
    
    public function update($url){
        $seasons = file_get_html('http://www.primewire.ag' . $url);
        
        // The easy part: updating the tracker
        $data = array(
            'url' => $url,
            'season' => 1,
            'episode' => 1
        );
        $this->db->update('series', $data);
        
        // The messy part: pulling the number of seasons and episodes
        $seasons = file_get_html('http://www.primewire.ag' . $url);
        $insert = array();
        foreach($seasons->find('.show_season') as $s){
            $insert[] = array('seasons' => $s->attr['data-id'], 'episodes' => count($s->children));
        }
        $this->db->truncate('series_data');
        $this->db->insert_batch('series_data', $insert);
        if($this->db->affected_rows() < 1){
            return 'Unable to update series.';
        }else{
            return 'Update complete. Ready to watch!';
        }
    }
 }
?>
