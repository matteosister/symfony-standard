<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Cypress\AssetsGalleryBundle\Entity\GalleryFolder;

class FoldersData implements FixtureInterface {
    public function load($manager) {
        $root = new GalleryFolder();
        $root->setName('root');
        
//        $child = new GalleryFolder();
//        $child->setName('child');
//        $child->setRelativePath('child/');
//        $child->setParent($root);
        
        $manager->persist($root);
        //$manager->persist($child);
        $manager->flush();
    }
}