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
    
    public function getName(){
        $this->db->select('name');
        return $this->db->get('series')->row_array()['name'];
    }
    
    public function getLinks(){
        // Assemble the URL of the page to scrape
        $result = $this->db->get('series')->result_array()[0];
        $url = 'http://www.primewire.ag' . str_replace('watch', 'tv', $result['url']) . '/season-' . $result['season'] . '-episode-' . $result['episode'];
        $contents = file_get_html($url);
        $hosts = $contents->find('.version_host');
        $videoLinks = $contents->find('.movie_version_link');
        
        // Get the sources and get every link I can
        $this->db->order_by('preference');
        $sources = $this->db->get('sources')->result_array();
        $links = array();
        
        foreach($sources as $source){
            foreach($hosts as $key => $host){
                if(strpos($host->innertext, $source['domain'])){
                    $links[] = array('domain' => $source['domain'], 'url' => 'http://www.primewire.ag' . $videoLinks[$key]->find('a')[0]->attr['href']);
//                    $redirect = 'http://www.primewire.ag' . $videoLinks[$key]->href;
                    
                    //Depending on the site type we go to one of the parsers
//                    if($source['type'] === 'gorillavid'){
//                        $links[]['url'] = $source['domain'] . $this->parseGorillavid($redirect);
//                    }else{
//                        $links[]['url'] = $this->parseNosvideo($redirect);
//                    }
                }
            }
        }
        return json_encode($links);
    }   
    
    private function parseGorillavid($redirect){
        $contents = file_get_html($redirect);
        $id = $contents->find('[name=id]')->attr['value'];
        return $id;
        
    }
    
    private function parseNosvideo($redirect){
        
    }
 
    public function getLocation(){
        //return json_encode($this->db->get('series')->row_array());
        $data = $this->db->get('series')->row_array();
        
        // Scrape for the name of the episode.
        $contents = file_get_html('http://www.primewire.ag' . str_replace('watch', 'tv', $data['url']) . '/season-' . $data['season'] . '-episode-' . $data['episode']);
        $title = $contents->find('.movie_info table tbody')[0]->find('tr')[1]->find('td')[1]->innertext;
        $data['title'] = $title;
        return json_encode($data);
    }
    
    public function stepVideo($direction){
        // Get current series location
        $this->db->select('season, episode');
        $current = $this->db->get('series')->row_array();        
        
        // Get number of episodes in current season.
        $this->db->select('episodes');
        $this->db->where('seasons', $current['season']);
        $episodesThisSeason = $this->db->get('series_data')->row_array()['episodes'];        
        
        if($direction === 'up'){
            // Check for upper bound
            $this->db->select_max('seasons');
            $maxSeason = $this->db->get('series_data')->row_array()['seasons'];
            $this->db->select('episodes');
            $this->db->where('seasons', $maxSeason);
            $maxEpisode = $this->db->get('series_data')->row_array()['episodes'];
            
            // Are we at upper bound? If so, reject, otherwise, approve.
            if($current['season'] == $maxSeason && $current['episode'] == $maxEpisode){
                return END_OF_SERIES;
            }else{
                if($current['episode'] == $episodesThisSeason){
                    $data = array(
                        'season' => $current['season'] + 1,
                        'episode' => 1
                    );
                }else{
                    $data = array(
                        'episode' => $current['episode'] + 1
                    );
                }    
            }
        }else{
            // Check for lower bound
            if($current['season'] == 1 && $current['episode'] == 1){
                return START_OF_SERIES;
            }else{
                if($current['episode'] == 1){
                    $this->db->select('episodes');
                    $this->db->where('seasons', $current['season'] - 1);
                    $lastSeasonEpisodes = $this->db->get('series_data')->row_array()['episodes'];
                    $data = array(
                        'season' => $current['season'] - 1,
                        'episode' => $lastSeasonEpisodes
                    );
                }else{
                    $data = array(
                        'episode' => $current['episode'] - 1
                    );
                }
            }
        }
        $this->db->update('series', $data);
        if($this->db->affected_rows() > 0){
            return STEP_SUCCESSFUL;
        }else{
            return STEP_UNSUCCESSFUL;
        }
    }
}



?>