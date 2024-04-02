<?php
namespace CustomeModule\PluginExample\Plugin;
class Name {
    public function aftergetName(\CustomeModule\PluginExample\Model\Page\PageName $subject, $result){
           return $result ." after_plugin_test";
    }

    public function beforesetName(\CustomeModule\PluginExample\Model\Page\PageName $subject, $name){
        return  "   Before_plugin_test".$name;
      }

      public function aroundgetName(\CustomeModule\PluginExample\Model\Page\PageName $subject, callable $proceed){
        return "- mid -" . $proceed() ."- mid -";
      }
}

?>