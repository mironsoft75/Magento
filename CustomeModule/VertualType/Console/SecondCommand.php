<?php
namespace CustomeModule\VertualType\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SecondCommand extends Command
{
    const NAME ="name";

    protected $helperClass;

 public function __construct(
    \CustomeModule\VertualType\Helper\HelperClassA $helperClass,
     string $name=null)
 {
        $this->helperClass=$helperClass;
        parent::__construct($name);

 }

   protected function configure()
   {
       $this->setName(name:'customemodule:VertualType:SecondCommand');
       $this->setDescription(description:'First Command');
       
       parent::configure();
   }
   protected function execute(InputInterface $input, OutputInterface $output)
   {
    
    $output->writeln($this->helperClass->getResult()); 

   }
}