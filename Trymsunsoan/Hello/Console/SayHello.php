<?php
namespace Trymsunsoan\Hello\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Sayhello extends Command
{
    protected function configure()
    {
        $this->setName('example:sayhello');
        $this->setDescription('Demo command line');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try{
            $apiUrl = "http://localhost/rest/V1/hello/name/Khang";
            $claimGuardKakekinJson = file_get_contents($apiUrl);
            $output->writeln($claimGuardKakekinJson);
            die();
        }catch( \Exception $e ){
            echo $e;
        }
    }
}