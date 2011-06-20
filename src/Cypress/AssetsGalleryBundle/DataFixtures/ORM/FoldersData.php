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
        $manager->persist($root);
        
        for ($i = 1; $i <= 10; $i++) {
            $child = new GalleryFolder();
            $child->setName('child '.$i);
            $child->setParent($root);
            $manager->persist($child);
        }
        
        $manager->flush();
    }
}