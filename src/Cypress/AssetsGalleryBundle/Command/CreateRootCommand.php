<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Cypress\AssetsGalleryBundle\Entity\GalleryFolder;

class CreateRootCommand extends ContainerAwareCommand
{
    protected function configure() {
        return $this
            ->setName('assetsgallery:create-root')
            ->setDescription('Create the root folder for your asset gallery');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $root = new GalleryFolder();
        $root->setName('root');
        $em->persist($root);
        $em->flush();
        $output->writeln('asset gallery root created! Enjoy :)');
    }
}