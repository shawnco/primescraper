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
                    $links[] = array('domain' => $source['domain'], 'url' => 'http://primewire.ag' . $videoLinks[$key]->find('a')[0]->attr['href']);
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
    
    public function parseGorillavid($redirect){
        $contents = file_get_html($redirect);
        $id = $contents->find('[name=id]')->attr['value'];
        return $id;
        
    }
    
    public function markWatched(){
        // Get current episode
        $this->db->select('season, episode');
        $result = $this->db->get('series')->row_array();
        
        // Get the season and episode of the very last episode.
        $this->db->select_max('seasons');
        $season = $this->db->get('series_data')->row()->seasons;
        $this->db->select('episodes');
        $this->db->where('seasons', $season);
        $episode = $this->db->get('series_data')->row()->episodes;
        
        if($season == $result['season'] && $episode == $result['episode']){
            return 'You have completed this series.';
        }else{
            // Find how many episodes this season is. We may need to advanced one season.
            $this->db->select('episodes');
            $this->db->where('seasons', $result['season']);
            $episodesThisSeason = $this->db->get('series_data')->row_array()['episodes'];
            
            // Advanced to the next season
            if($result['episode'] == $episodesThisSeason){
                $update = array(
                    'season' => $result['season'] + 1,
                    'episode' => 1
                );
                $this->db->update('series', $update);
            }else{
            // Advance to the next episode
                $update = array(
                    'episode' => $result['episode'] + 1
                );
                $this->db->update('series', $update);
            }
            if($this->db->affected_rows() < 1){
                return 'Unable to mark as watched.';
            }else{
                return 'Marked as watched! Reload to watch the next episode.';
            }
        }
        
        
    }
}



?>