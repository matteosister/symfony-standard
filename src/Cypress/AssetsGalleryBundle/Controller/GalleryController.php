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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

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
     * dumb method for autocompletion
     * @return Doctrine\ORM\EntityManager
     */
    private function getEM()
    {
        return $this->container->get('doctrine')->getEntityManager();
    }
    
    /**
     * dumb method for autocompletion
     * @return Symfony\Component\HttpFoundation\Request
     */
    private function getRequest()
    {
        return $this->container->get('request');
    }
    
    public function listAction($folder_id)
    {
        if ($folder_id) {
            $folder = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->find($folder_id);
        } else {
            $folder = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->findOneBy(array('level' => 0));
        }
        $assets = $folder->getAsset();

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

        return $this->getFormResponse($this->processAssetForm($asset));
    }
    
    public function addAssetInFolder($id)
    {
        $folder = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->find($id);
        $asset = new GalleryAsset();
        $asset->setFolder($folder);
        
        return $this->getFormResponse($this->processAssetForm($asset));
    }
    
    private function processAssetForm(GalleryAsset $asset)
    {
        $request = $this->container->get('request');
        $form = $this->container->get('form.factory')->create(new GalleryAssetType(), $asset);
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getEM()->persist($asset);
                $this->getEM()->flush();
            }
        }
        return $form;
    }
    
    public function manageFolderAction($id)
    {
        if ($id) {
            $folder = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->find($id);
        } else {
            $folder = new GalleryFolder();
        }
        
        return $this->getFormResponse($this->processFolderForm($folder));
    }
    
    public function addFolderInFolder($id)
    {
        $parent = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->find($id);
        $folder = new GalleryFolder();
        $folder->setParent($parent);
        
        return $this->getFormResponse($this->processFolderForm($folder));
    }
    
    private function processFolderForm(GalleryFolder $folder)
    {
        $request = $this->container->get('request');
        $form = $this->container->get('form.factory')->create(new GalleryFolderType(), $folder);
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getEM()->persist($folder);
                $this->getEM()->flush();
            }
        }
        return $form;
    }
    
    private function getFormResponse(Form $form)
    {
        if ($form->getData() instanceof GalleryAsset) {
            $context = 'asset';
        }
        if ($form->getData() instanceof GalleryFolder) {
            $context = 'folder';
        }
        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:form.html.twig', array(
                'form'      => $form->createView(),
                'context'   => $context,
                'base_path' => '/'.$this->container->getParameter('assets_gallery.base_path').'/'
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
    
    public function sortFolderAction()
    {
        $req = $this->getRequest();
        $folderId = $req->get('folder_id');
        $newPosition = $req->get('new_position');
        $repo = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder');
        $folder = $repo->find($folderId);
        $siblings = $folder->getParent()->getChildren();
        foreach ($siblings as $i => $child) {
            if ($child->getId() == $folder->getId()) {
                if ($newPosition != $i) {
                    if ($newPosition > $i) {
                        $repo->moveDown($folder, $newPosition - $i);
                    } else {
                        $repo->moveUp($folder, $i - $newPosition);
                    }
                }
            }
        }
        
        return new Response('OK');
    }
}
