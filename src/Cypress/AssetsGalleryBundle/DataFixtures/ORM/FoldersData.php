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
        
        $child1 = new GalleryFolder();
        $child1->setName('child 1');
        $child1->setParent($root);
        
        $child2 = new GalleryFolder();
        $child2->setName('child 2');
        $child2->setParent($root);
        
        $child3 = new GalleryFolder();
        $child3->setName('child 3');
        $child3->setParent($root);
        
//        $child4 = new GalleryFolder();
//        $child4->setName('second child 2');
//        $child4->setParent($child2);
        
        $manager->persist($root);
        $manager->persist($child1);
        $manager->persist($child2);
        $manager->persist($child3);
        //$manager->persist($child4);
        
        $manager->flush();
    }
}