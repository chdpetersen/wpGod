<?php
namespace WpGod\WpgodAutoload;

class WpgodAutoload{

  public function __construct(){
    $this->setWpgodRegister();
  }  
 
  private function setWpgodRegister(){
    spl_autoload_register(array($this, 'wpgodAutoload'));
  }

  private function wpgodAutoload($className){
    $className = ltrim($className, '\\');
    // Define your plugin's root namespace(s) or prefixes.
    // These are the namespaces that this autoloader is responsible for.
    $plugin_prefixes = array(
        'WpGod\\',      // For classes like WpGod\Something\Else
        'Components\\',  // For classes like Components\WpGodMainImage
        'Sections\\'
        // Add any other top-level namespaces your plugin uses here.
    );

    $is_plugin_class = false;
    foreach ($plugin_prefixes as $prefix) {
        if (strpos($className, $prefix) === 0) {
            $is_plugin_class = true;
            break;
        }
    }

    // If it's not a class this autoloader is responsible for,
    // return early and let other autoloaders (e.g., WordPress core) handle it.
    if (!$is_plugin_class) {
        return;
    }
     // Original logic for converting class name to file path for plugin classes
    $fileName  = '';
    $namespace_part = ''; // Renamed from $namespace to avoid confusion
    $class_part = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace_part = substr($className, 0, $lastNsPos);
        $class_part = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace_part) . DIRECTORY_SEPARATOR;
    } else {
        // This case should ideally not be hit if prefixes are well-defined and namespaced.
        $class_part = $className;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $class_part) . '.php';

    // Construct the full path relative to this autoloader's directory
    $full_file_path = __DIR__ . DIRECTORY_SEPARATOR . $fileName;

    if (file_exists($full_file_path)) {
        require_once $full_file_path;
    }
    // If the file doesn't exist even after passing the prefix check,
    // it implies a misconfiguration or missing file within the plugin's structure.
    // No explicit error here allows for potential fallbacks, though for plugin classes, this would be an issue.
  }
} 
new WpgodAutoload();