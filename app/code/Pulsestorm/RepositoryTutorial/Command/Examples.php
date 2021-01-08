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
         $page = $repo->getById(8);
   /*     $page->setId(null);
        $page->setTitle('My Duplicated Page');
        $repo->save($page);
        echo $page->getId(),"\n";*/
        $repo->delete($page);
//        $repo->deleteById($page_id);

        /*$repo = $this->objectManager->get('Magento\Catalog\Model\ProductRepository');
        $repo->getList();*/
    }


} 