<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Entity;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Cypress\AssetsGalleryBundle\Entity\GalleryFolder;
use Cypress\AssetsGalleryBundle\Entity\GalleryAsset;

class GalleryEntitiesListener implements EventSubscriber
{
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function getSubscribedEvents() {
        return array(
            Events::prePersist,
            Events::preRemove
        );
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof GalleryFolder) {
            if ($entity->getParent() == null) {
                $entity->setLevel(1);
            } else {
                $entity->setLevel($entity->getParent()->getLevel() + 1);
            }
        }
    }
    
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof GalleryAsset) {
            $filename = $this->container->getParameter('assets_gallery.base_path').DIRECTORY_SEPARATOR.$entity->getFilename();
            @unlink($filename);
        }
    }
}