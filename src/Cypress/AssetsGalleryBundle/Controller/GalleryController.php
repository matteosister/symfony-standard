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
use Cypress\AssetsGalleryBundle\Form\AssetType;
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
    
    public function listAction()
    {
        $repo = $this->getEM()->getRepository('Cypress\AssetsGalleryBundle\Entity\GalleryFolder');
        var_dump($repo);
        die();
        $assets = $this->getEM()->getRepository('Cypress\AssetsGalleryBundle\Entity\GalleryAsset')->findAll();
        
        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:list.html.twig', array(
                'assets' => $assets,
                'base_path' => '/'.$this->container->getParameter('assets_gallery.base_path').'/'
            ));
    }
    
    public function addAction()
    {
        $asset = new GalleryAsset;
        $form = $this->container->get('form.factory')->create(new AssetType(), $asset);
        
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
    
    public function deleteAction($id)
    {
        $asset = $this->getEM()->getRepository('Cypress\AssetsGalleryBundle\Entity\GalleryAsset')->find($id);
        if ($asset) {
            $this->getEM()->remove($asset);
            $this->getEM()->flush();
        }
        return new RedirectResponse($this->container->get('router')->generate('cypress_gallery_list'));
    }
    
    private function manageAssetSave(GalleryAsset &$asset)
    {
        $uploadedFile = $asset->getFilename();
        $path = $this->container->getParameter('assets_gallery.base_path');
        $newName = $this->container->get('assets_gallery.util')->generateToken().
                '.'.$uploadedFile->getExtension();
        $uploadedFile->move($path, $newName);
        $asset->setFilename($newName);
    }
}
