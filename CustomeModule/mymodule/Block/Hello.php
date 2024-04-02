<?php
namespace CustomeModule\mymodule\Block;

use Magento\Framework\View\Element\Template;

class Hello extends Template
{
    public function getHelloMessage()
    {
        return "Hello";
    }
}
