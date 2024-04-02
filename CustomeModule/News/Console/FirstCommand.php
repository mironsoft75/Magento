<?php
namespace CustomeModule\News\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FirstCommand extends Command
{
    const NAME ="name";

    protected $helperClassA;
    protected $helperClassB;

 public function __construct(
    \CustomeModule\News\Helper\HelperClassA $helperClassA,
    \CustomeModule\News\Helper\HelperClassBFactory  $helperClassB,
     string $name=null)
 {
$this->helperClassA =$helperClassA;
$this->helperClassB =$helperClassB;
parent::__construct($name);

 }

   protected function configure()
   {
       $this->setName(name:'customemodule:firstcommand:displayname');
       $this->setDescription(description:'First Command');
       
        $this->addOption(
       name: self::NAME,
       shortcut:null,
       mode:InputOption::VALUE_REQUIRED,
       description: 'Name'
        );

       parent::configure();
   }
   protected function execute(InputInterface $input, OutputInterface $output)
   {
    if($name = $input->getOption(name:self::NAME)){
        $output->writeln( messages: '<info>Provied name is'. $name.'</info>');
    }
    $helperClass=$this->helperClassB->create();
    $helperClass->setVariableA(20);
    $helperClass->setVariableB(50);
    $output->writeln($this->helperClassA->calculateResult($helperClass));
    $helperClass->setVariableA(70);
    $helperClass->setVariableB(200);
    $output->writeln($this->helperClassA->calculateResult($helperClass));
    // $output->writeln($this->helperClassA->calculateResult()); // when user construct function 

   }
}