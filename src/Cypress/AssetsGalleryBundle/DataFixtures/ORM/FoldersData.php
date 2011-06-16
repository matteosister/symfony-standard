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
        $child->setName('child with a very long name');
        $child->setParent($root);
        
        $child2 = new GalleryFolder();
        $child2->setName('second child');
        $child2->setParent($child);
        
        $child3 = new GalleryFolder();
        $child3->setName('second child 2');
        $child3->setParent($child);
        
        $child4 = new GalleryFolder();
        $child4->setName('third child');
        $child4->setParent($child2);
        
        $manager->persist($root);
        $manager->persist($child);
        $manager->persist($child2);
        $manager->persist($child3);
        $manager->persist($child4);
        
        $manager->flush();
    }
}