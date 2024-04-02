<?php
 namespace CustomeModule\PluginExample\Model\Page;

 class PageName implements \CustomeModule\PluginExample\Model\PageInterface
 {
    protected $name ;

    public function setName($name){
        $this->name=$name;
    }

    public function getName(){
        return $this->name;
    }
 }
?>