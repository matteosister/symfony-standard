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
        
        $child = new GalleryFolder();
        $child->setName('child');
        $child->setParent($root);
        
        $child2 = new GalleryFolder();
        $child2->setName('second child');
        $child2->setParent($child);
        
        $manager->persist($root);
        $manager->persist($child);
        $manager->persist($child2);
        $manager->flush();
    }
}