<?php
namespace Pulsestorm\RepositoryTutorial\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Examples extends Command
{
    protected $objectManager;
    protected function configure()
    {
        $this->setName("ps:examples");
        $this->setDescription("A command the programmer was too lazy to enter a description for.");
        parent::configure();
    }

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\State $appState,
        $name=null
    )
    {
        $this->objectManager = $objectManager;
        $appState->setAreaCode('frontend');
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $repo = $this->objectManager->get('Magento\Cms\Model\PageRepository');
         $page = $repo->getById(2);
         echo $page->getTitle(),"\n";
        exit;
        echo get_class($page),"\n";
        /*$repo = $this->objectManager->get('Magento\Catalog\Model\ProductRepository');
        $repo->getList();*/
    }


} 