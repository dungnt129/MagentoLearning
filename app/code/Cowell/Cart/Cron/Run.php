<?php
namespace Cowell\Cart\Cron;

class Run
{
    protected $_logger;
    public function __construct(
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_logger = $logger;
    }

    public function execute()
    {
        //Edit it according to your requirement
        $this->_logger->info('Cron run successfully');
        return $this;
    }
}