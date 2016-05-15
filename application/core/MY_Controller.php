<?php

/**
 * Extends some of the functionality for the application.
 * 
 * @author Shawn Contant <shawnc366@gmail.com>
 */

// @TODO: Make this into a library?
include('assets/simplehtmldom/simple_html_dom.php');
class MY_Controller extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->data['js'] = array();
        $this->data['css'] = array();
        $this->addStyle('style.css');
        $this->addScript(array('default.js', 'jquery.min.js', 'jquery-ui/jquery-ui.min.js'));
    }
    
    /**
     * Adds a JavaScript file to be added.
     * @param string/Array $fname A name or array of names of files to be added.
     * @return boolean Whether or not the file(s) were added.
     */
    public function addScript($fname){
        if(gettype($fname) === 'string'){
            $this->data['js'][] = base_url() . 'assets/js/' . $fname;
            return TRUE;
        }else if(gettype($fname) === 'array'){
            foreach($fname as $f){
                $this->data['js'][] = base_url() . 'assets/js/' . $f;
            }
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * Adds a CSS file to be added.
     * @param string/Array $fname A name or array of names of files to be added.
     * @return boolean Whether or not the file(s) were added.
     */    
    public function addStyle($fname){
        if(gettype($fname) === 'string'){
            $this->data['css'][] = base_url() . '/assets/css/' . $fname;
            return TRUE;
        }else if(gettype($fname) === 'array'){
            foreach($fname as $f){
                $this->data['css'][] = base_url() . '/assets/css/' . $f;
            }
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * Shorthand to display the template and one or more views
     * @param string/array $view One or more views to display
     */
    public function display($view, $data){
        $this->load->view('template/header', $data);
        if(gettype($view) == 'string'){
            $this->load->view($view, $data);
        }else if(gettype($view) == 'array'){
            foreach($view as $v){
                $this->load->view($v, $data);
            }
        }
        $this->load->view('template/footer', $data);
    }
}
?>

