<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Vivacom\CmsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Vivacom\CmsBundle\Entity\Page;

class PagesData implements FixtureInterface {
    public function load($manager) {
        // load 100 pages
        for ($i = 1; $i <= 100; $i++) {
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
            $manager->persist($page);
        }
        $manager->flush();
    }
}