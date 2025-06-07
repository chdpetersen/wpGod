<?php
namespace Components;

class WpGodSectionsHeader{

  private $legend;

  public function __construct($_legend)
  {
    $this->legend = $_legend;
  }

  public function getSectionsHeaderHtml(){

    
    $mainImage = new \Components\WpGodMainImage();
    echo $mainImage->getImageHtml(); 
    ?>
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <p><?php _e( $this->legend, "wpgod" ); ?></p>
  <?php
  }


}
