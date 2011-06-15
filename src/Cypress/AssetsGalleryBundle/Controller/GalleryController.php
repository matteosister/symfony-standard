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
    
    public function listAction($level = 1)
    {
        $assets = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryAsset')->findByFolderLevel($level);
        $folders = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->findChildrenOf($level);
        
        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:list.html.twig', array(
                'assets'    => $assets,
                'folders'   => $folders,
                'base_path' => '/'.$this->container->getParameter('assets_gallery.base_path').'/'
            ));
    }
    
    public function addAssetAction()
    {
        $asset = new GalleryAsset;
        $form = $this->container->get('form.factory')->create(new GalleryAssetType(), $asset);
        
        $request = $this->container->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->manageAssetSave($asset);
                $this->getEM()->persist($asset);
                $this->getEM()->flush();
            }
        }

        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:new.html.twig', array(
                'form' => $form->createView()
            ));
    }
    
    public function addFolderAction()
    {
        $gallery_folder = new GalleryFolder();
        $form = $this->container->get('form.factory')->create(new GalleryFolderType(), $gallery_folder);
        
        $request = $this->container->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getEM()->persist($gallery_folder);
                $this->getEM()->flush();
            }
        }

        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:new_folder.html.twig', array(
                'form' => $form->createView()
            ));
    }
    
    public function editFolderAction($id)
    {
        $gallery_folder = $this->getEM()
                ->getRepository('AssetsGalleryBundle:GalleryFolder')
                ->find($id);
        $form = $this->container->get('form.factory')->create(new GalleryFolderType(), $gallery_folder);
        
        $request = $this->container->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getEM()->persist($gallery_folder);
                $this->getEM()->flush();
            }
        }
        
        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:new_folder.html.twig', array(
                'form' => $form->createView()
            ));
    }
    
    public function deleteAssetAction($id)
    {
        $asset = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryAsset')->find($id);
        if ($asset) {
            $this->getEM()->remove($asset);
            $this->getEM()->flush();
        }
        return new RedirectResponse($this->container->get('router')->generate('cypress_gallery_list'));
    }
    
    public function deleteFolderAction($id)
    {
        $folder = $this->getEM()->getRepository('AssetsGalleryBundle:GalleryFolder')->find($id);
        if ($folder) {
            $this->getEM()->remove($folder);
            $this->getEM()->flush();
        }
        return new RedirectResponse($this->container->get('router')->generate('cypress_gallery_list'));
    }
    
    private function manageAssetSave(GalleryAsset &$asset)
    {
//        $uploadedFile = $asset->getFilename();
//        $path = $this->container->getParameter('assets_gallery.base_path');
//        $newName = $this->container->get('assets_gallery.util')->generateToken().
//                '.'.$uploadedFile->getExtension();
//        $uploadedFile->move($path, $newName);
//        $asset->setFilename($newName);
    }
}
