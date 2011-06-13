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
        return $this
            ->container
            ->get('templating')
            ->renderResponse('AssetsGalleryBundle:Gallery:list.html.twig');
    }
    
    public function addAction()
    {
        $asset = new GalleryAsset;
        $form = $this->container->get('form.factory')->create(new AssetType(), $asset);
        
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
            ->renderResponse('AssetsGalleryBundle:Gallery:new.html.twig', array(
                'form' => $form->createView()
            ));
    }
}
