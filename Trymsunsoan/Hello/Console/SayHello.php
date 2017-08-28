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
//        try{
//            $apiUrl = "http://192.168.33.10/rest/V1/hello/name/Khang";
//            $claimGuardKakekinJson = file_get_contents($apiUrl);
//            $output->writeln($claimGuardKakekinJson);
//            die();
//        }catch( \Exception $e ){
//            echo $e;
//        }


        try{

            $httpHeaders = new \Zend\Http\Headers();
            $httpHeaders->addHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]);
            $request = new \Zend\Http\Request();
            $request->setHeaders( $httpHeaders );
            $request->setUri( 'http://192.168.33.10/rest/V1/hello/getProduct' );
            $request->setMethod( \Zend\Http\Request::METHOD_GET );

            $client = new \Zend\Http\Client();
            $options = [
                'adapter' => 'Zend\Http\Client\Adapter\Curl',
                'curloptions' => [ CURLOPT_FOLLOWLOCATION => true ],
                'maxredirects' => 0,
                'timeout' => 30
            ];

            try{
                $client->setOptions( $options );
                $response = $client->send( $request );
                print_r( $response );
            }catch (\Exception $e){
                echo 'error';
                die();
            }

        }catch( \Exception $e ){
            echo $e;
        }
    }
}