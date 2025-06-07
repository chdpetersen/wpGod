<?php
namespace Sections;

class PoweredBy{

  private $legend = "This plugin is supported by:";
  
  public function getPoweredByHtml(){
    ?>
    <div class="wrap">
        <?php 
        $sectionHeader = new \Components\WpGodSectionsHeader($this->legend);
        $sectionHeader->getSectionsHeaderHtml();
        ?>
        <p><a href="https://github.com/chdpetersen">Christian Petersen</a></p>
        <p><a href="https://www.vecteezy.com/">Vecteezy</a></p>
    </div>
    <?php
  }  

}  