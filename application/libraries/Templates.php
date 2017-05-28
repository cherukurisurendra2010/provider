<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
/** 
 * Layouts Class. PHP5 only. 
 * 
 */
class Templates { 
    
  // Will hold a CodeIgniter instance 
  private $CI; 
    
  // Will hold a title for the page, NULL by default 
  private $title_for_layout = NULL; 
    
  // The title separator, ' | ' by default 
  private $title_separator = ' | ';
  
  private $layout =  'default';
    
  public function __construct()
  { 
    $this->CI =& get_instance();
  } 
    
  public function set_title($title)
  { 
    $this->title_for_layout = $title;
  }
  
  public function setLayout($layout){
    $this->layout = $layout; 
  }
  
  public function load($view_name, $params = array()){ 
    // Load the view's content, with the params passed 
    $view_content = $this->CI->load->view($view_name, $params, TRUE); 
  
    // Now load the layout, and pass the view we just rendered 
    $this->CI->load->view('layouts/' . $this->layout, array( 
      'content' => $view_content,'assets_base_url' => $this->CI->config->item('assets_base_url')
    ));
  }
  
  public function view($view_name, $params = array(), $layout = 'default') 
  {  
    // Handle the site's title. If NULL, don't add anything. If not, add a  
    // separator and append the title. 
    if ($this->title_for_layout !== NULL)  
    { 
      $separated_title_for_layout = $this->title_separator . $this->title_for_layout; 
    } 
      
    // Load the view's content, with the params passed 
    $view_content = $this->CI->load->view($view_name, $params, TRUE); 
  
    // Now load the layout, and pass the view we just rendered 
    $this->CI->load->view('layouts/' . $layout, array( 
      'content_for_layout' => $view_content, 
      'title_for_layout' => $separated_title_for_layout
    )); 
  } 
    
  public function add_include($path) 
  { 
    $this->CI->load->helper('url'); // Load this just to be sure 
    $this->file_includes[] = $this->CI->config->item('assets_base_url').$path;   
    return $this; // This allows chain-methods 
  } 
  
  public function print_includes() 
  { 
    // Initialize a string that will hold all includes 
    $final_includes = ''; 
  
    foreach ($this->file_includes as $include) 
    { 
      // Check if it's a JS or a CSS file 
      if (preg_match('/js$/', $include)) 
      { 
        // It's a JS file 
        $final_includes .= '<script language="JavaScript" type="text/javascript" src="' . $include . '"></script>'; 
      } 
      elseif (preg_match('/css$/', $include)) 
      { 
        // It's a CSS file 
        $final_includes .= '<link href="' . $include . '" rel="stylesheet" type="text/css" />'; 
      } 
  
     
    } 
    return $final_includes;  
  } 
}