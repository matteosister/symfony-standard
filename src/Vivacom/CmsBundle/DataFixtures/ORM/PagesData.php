<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Vivacom\CmsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Vivacom\CmsBundle\Entity\Page;
use Vivacom\CmsBundle\Entity\Meta;

class PagesData implements FixtureInterface {
    public function load($manager) {
        $metaK = new Meta();
        $metaK->setName('keywords');
        $metaK->setContent('page,cms,vivacom');
        $manager->persist($metaK);
        
        $metaD = new Meta();
        $metaD->setName('description');
        $metaD->setContent('Lorem ipsum dolor sit amet');
        $manager->persist($metaD);
        
        // load 100 pages
        for ($i = 1; $i <= 5; $i++) {
            switch (strlen($i)) {
                case 1:
                    $i = "00".$i;
                    break;
                case 2:
                    $i = "0".$i;
                    break;
            }
            $page = new Page();
            $page->setName('the name ' . $i);
            $page->setContent('The content ' . $i);
            $page->setMetas(rand(1,2) == 1 ? $metaD : $metaK);
            $manager->persist($page);
        }
        $manager->flush();
    }
}