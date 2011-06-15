<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GalleryFolderRepository extends EntityRepository
{
    public function findChildrenOf($level)
    {
        $query = $this->getEntityManager()
                ->createQuery('SELECT f FROM AssetsGalleryBundle:GalleryFolder f WHERE f.level = :level')
                ->setParameter('level', $level++);
        
        return $query->getResult();
    }
}