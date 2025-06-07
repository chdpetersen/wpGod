<?php
namespace Sections;

class WpGod{

  private $legend = "Welcome to the WpGod plugin Main page. Here you will configure the <span>ultimate</span> access!";
  
  public function getWpGodHtml(){
    ?>
    <div class="wrap">
        <?php 
        $sectionHeader = new \Components\WpGodSectionsHeader($this->legend);
        $sectionHeader->getSectionsHeaderHtml();
        ?>
    
    </div>
    <?php
  }  

}  