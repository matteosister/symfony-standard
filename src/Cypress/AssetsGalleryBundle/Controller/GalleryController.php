<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Cypress\AssetsGalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Cypress\AssetsGalleryBundle\Entity\GalleryAsset;
use Cypress\AssetsGalleryBundle\Entity\GalleryFolder;
use Cypress\AssetsGalleryBundle\Form\GalleryAssetType;
use Cypress\AssetsGalleryBundle\Form\GalleryFolderType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GalleryController extends ContainerAware
{
    /**
     * the service container
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    /**
     * dump method for autocompletion
     * @return Doctrine\ORM\EntityManager
     */
    private function getEM()
    {
        return $this->container->get('doctrine')->getEntityManager();
    }
    
    public function listAction($folder_id)
    {
        if ($folder_id) {
            $folder = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->find($folder_id);
        } else {
            $folder = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->findOneBy(array('level' => 0));
        }
        $assets = $folder->getAsset();
        //$folders = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->findBy(array('level' => $folder->getLevel() + 1));
        
        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:list.html.twig', array(
                'assets'    => $assets,
                'folder'   => $folder,
                'base_path' => '/'.$this->container->getParameter('assets_gallery.base_path').'/'
            ));
    }
    
    public function manageAssetAction($id)
    {
        if ($id) {
            $asset = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryAsset')->find($id);
        } else {
            $asset = new GalleryAsset();
        }
        
        $form = $this->container->get('form.factory')->create(new GalleryAssetType(), $asset);
        
        $request = $this->container->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getEM()->persist($asset);
                $this->getEM()->flush();
            }
        }

        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:form.html.twig', array(
                'form'    => $form->createView(),
                'context' => 'asset'
            ));
    }
    
    public function manageFolderAction($id)
    {
        if ($id) {
            $folder = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->find($id);
        } else {
            $folder = new GalleryFolder();
        }
        $form = $this->container->get('form.factory')->create(new GalleryFolderType(), $folder);
        
        $request = $this->container->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getEM()->persist($folder);
                $this->getEM()->flush();
            }
        }
        
        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:form.html.twig', array(
                'form'    => $form->createView(),
                'context' => 'folder'
            ));
    }
    
    public function deleteAssetAction($id)
    {
        $asset = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryAsset')->find($id);
        $folder_id = null;
        if ($asset) {
            if ($asset->getFolder() != null) {
                $folder_id = $asset->getFolder()->getId();
            }
            $this->getEM()->remove($asset);
            $this->getEM()->flush();
        }
        return new RedirectResponse($this->container->get('router')->generate(
                'cypress_gallery_list', array ('folder_id' => $folder_id)
        ));
    }
    
    public function deleteFolderAction($id)
    {
        $folder = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->find($id);
        $parent_id = null;
        if ($folder && !$folder->isRoot()) {
            $parent_id = $folder->getParent()->getId();
            $this->getEM()->remove($folder);
            $this->getEM()->flush();
        }
        
        return new RedirectResponse($this->container->get('router')->generate(
                'cypress_gallery_list', array('folder_id' => $parent_id)
        ));
    }
}
