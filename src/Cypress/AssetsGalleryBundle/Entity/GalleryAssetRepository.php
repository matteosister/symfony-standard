<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GalleryAssetRepository extends EntityRepository
{
    public function findByFolderLevel($level)
    {
        $query = $this->getEntityManager()
                ->createQuery('SELECT a
                    FROM AssetsGalleryBundle:GalleryAsset a
                    JOIN a.folder f WHERE f.level = :level')
                ->setParameter('level', $level);
        
        return $query->getResult();
    }
}