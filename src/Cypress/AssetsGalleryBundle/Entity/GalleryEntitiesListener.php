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
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\File\File;

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
            Events::postPersist,
            Events::preRemove
        );
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        
        // GalleryFolder
        if ($entity instanceof GalleryFolder) {
            if ($entity->getParent() == null) {
                $entity->setLevel(1);
            } else {
                $entity->setLevel($entity->getParent()->getLevel() + 1);
            }
        }
        
        // GalleryAsset
        if ($entity instanceof GalleryAsset) {
            $entity->setFilename($this->generateFilename($entity));
        }
    }
    
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        
        if ($entity instanceof GalleryAsset) {
            if ($entity->getFile()->move($this->container->getParameter('assets_gallery.base_path'), $entity->getFilename()) instanceof File) {
                $entity->setFile(null);
            } else {
                throw new UploadException();
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
    
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        // GalleryAsset
        if ($entity instanceof GalleryAsset) {
            $this->manageAssetSave($entity);
        }
    }
    
    private function generateFilename(GalleryAsset $asset)
    {
        $uploadedFile = $asset->getFile();
        $ext = $uploadedFile->guessExtension() == null ? $uploadedFile->getExtension() : $uploadedFile->guessExtension();
        $newName = $this->container->get('assets_gallery.util')->generateToken().'.'.$ext;
        return $newName;
    }
}