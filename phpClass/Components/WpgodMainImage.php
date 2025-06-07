<?php
namespace Components;

class WpGodMainImage{
  
  private $image = 'owl_completo.png';
  private $title = 'WpGod Owl Image';
  private $alt = 'WpGod Owl Image';
  private $path = 'wpGod/storage/owl/';
  private $url;
  private $html;


  public function __construct(){

    $this->setImageSrc();
    $this->setImageHtml();
    wp_enqueue_style('WpGodMainImage-style', plugin_dir_url('wpGod.php' ) . 'wpGod/css/Components/WpGodMainImage.css' );
    wp_enqueue_script('WpGodMainImage-script', plugin_dir_url('wpGod.php' ) . 'wpGod/jsClass/Components/WpGodMainImage.js', array(), null, true);
  } 

  private function setImageSrc(){
   
    $this->url = esc_url(plugin_dir_url('wpGod.php').$this->path.$this->image);
  }

  private function setImageHtml(){
    $this->html = "<img id='WpGodMainImage' class='WpGodMainImage' src=".$this->url." alt='WpGod Owl Image' title='WpGod Owl Image'/>";
  }

   public function getImageHtml():string{
    return $this->html;
  }

}