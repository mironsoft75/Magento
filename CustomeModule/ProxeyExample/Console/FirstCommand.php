<?php
namespace CustomeModule\ProxeyExample\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FirstCommand extends Command
{
    const NAME ="name";

    protected $helperClass;
    protected $b;
    protected $c;

 public function __construct(
    \CustomeModule\ProxeyExample\Helper\HelperClassB $helperClass,
     string $name=null,$c=20,
     $b=100)
 {         
        $this->b=$b;
        $this->c=$c;
        $this->helperClass=$helperClass;
        parent::__construct($name);

 }

   protected function configure()
   {
       $this->setName(name:'customemodule:ProxeyExample:ShowResult');
       $this->setDescription(description:'First Command');
       
       parent::configure();
   }
   protected function execute(InputInterface $input, OutputInterface $output)
   {
   
    echo "Run";
    $d=$this->helperClass->getResult();
    $output->writeln($this->c."=".$d); 

   }
}