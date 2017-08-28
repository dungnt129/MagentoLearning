<?php
namespace Dmit\Banner\Console;

use Dmit\Banner\Model\Banner;
use Dmit\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeleteBanner extends Command
{
    /**
     * Banner argument
     */
    const BANNER_ARGUMENT = 'id';

    /**
     * Allow all
     */
    const ALLOW_ALL = 'allow-all';

    /**
     * All banner id
     */
    const ALL_BANNER = 'All';

    /**
     * Banner
     *
     * @var Banner
     */
    private $banner;

    /**
     * @var \Dmit\Banner\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $bannerCollectionFactory;

    protected $logger;
    /**
     * @param ModuleListInterface $moduleList
     */
    public function __construct(
        Banner $banner,
        CollectionFactory $bannerCollectionFactory,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->banner = $banner;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->logger = $logger;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('banner:delete');
        $this->setDescription('Delete banner command');
        $this->addArgument(
            self::BANNER_ARGUMENT,   // name
            InputArgument::OPTIONAL, // mode
            'Banner id'              // brief
        );
        $this->addOption(
            self::ALLOW_ALL,            // name
            '-a',                       // shortcut
            InputOption::VALUE_NONE,    // mode
            'Allow delete all banner'   // brief
        );


//        $this->setName('example:DeleteBanner')
//            ->setDescription('Delete banner command')
//            ->setDefinition([
//                new InputArgument(
//                    self::BANNER_ARGUMENT,   // name
//                    InputArgument::OPTIONAL, // mode
//                    'Banner id'              // brief
//                ),
//                new InputOption(
//                    self::ALLOW_ALL,          // name
//                    '-a',                     // shortcut
//                    InputOption::VALUE_NONE,  // mode
//                    'Allow delete all banner' // brief
//                ),
//
//            ]);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->logger->info('------ Start command delete banner ------');
            $bannerId = $input->getArgument(self::BANNER_ARGUMENT);
            $allowAll = $input->getOption(self::ALLOW_ALL);
            if (is_null($bannerId)) {
                if ($allowAll) {
                    $bannerAllColl = $this->bannerCollectionFactory->create();  //Get banner Collection
                    foreach ($bannerAllColl as $bannerCollData) {
                        $bannerCollData->delete();                             //Delete banner
                    }
                    $this->logger->info('Delete all banner success');
                    $output->writeln('<info>All banners are deleted.</info>'); //Displaying output on terminal
                } else {
                    throw new \InvalidArgumentException('Argument ' . self::BANNER_ARGUMENT . ' is missing.');
                }
            }

            if($bannerId){
                $bannerColl = $this->banner->load($bannerId);
                if(empty($bannerColl) || !$bannerColl->getId()){
                    $output->writeln('<info>Banner with id ' . $bannerId . ' does not exist.</info>');
                }else{
                    $bannerColl->delete();                                    //Delete banner
                    $this->logger->info('Delete banner with id ' . $bannerId . ' is deleted');
                    $output->writeln('<info>Banner with id ' . $bannerId . ' is deleted.</info>');
                }
            }
            $this->logger->info('------ End command delete banner ------');
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            $output->writeln('<error>Please disable maintenance mode after you resolved above issues</error>');

            return \Magento\Framework\Console\Cli::RETURN_FAILURE;
        }
    }
}