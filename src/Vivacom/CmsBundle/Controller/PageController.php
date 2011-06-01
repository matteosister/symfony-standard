<?php

/*
 * matteosister
 * just for fun...
 */

namespace Vivacom\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Vivacom\CmsBundle\Entity\Page;
use Vivacom\CmsBundle\Form\PageType;


class PageController extends Controller 
{   
    public function dashboardAction()
    {
        return $this->render('CmsBundle:Backend:dashboard.html.twig');
    }
    
    public function pagesAction()
    {
        $util = $this->get('utilities');
        $em = $this->get('doctrine')->getEntityManager();
        $pages = $em->getRepository('Vivacom\CmsBundle\Entity\Page')->findAll();
        
        
        return $this->render('CmsBundle:Backend:pages.html.twig', array(
            'pages' => $pages
        ));
    }
    
    public function pagesNewAction()
    {
        $page = new Page();
        
        $form = $this->get('form.factory')->create(new PageType(), $page);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $this->get('session')->setFlash('notice', 'Your changes were saved!');
                $em = $this->get('doctrine')->getEntityManager();
                $em->persist($page);
                $em->flush();
                
                return $this->redirect($this->generateUrl('be_page_edit', array(
                    'isNew' => true,
                    'id' => $page->getId()
                )));
            }
        }
        
        return $this->render('CmsBundle:Backend:pageform.html.twig', array(
            'isNew' => true,
            'form' => $form->createView(),
        ));
    }
    
    public function pagesEditAction($id)
    {
        $page = $this->get('doctrine')->getEntityManager()->find('Vivacom\CmsBundle\Entity\Page', $id);
        
        $form = $this->get('form.factory')->create(new PageType(), $page);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $this->get('session')->setFlash('notice', 'Your changes were saved!');
                $em = $this->get('doctrine')->getEntityManager();
                $em->persist($page);
                $em->flush();
                
                return $this->redirect($this->generateUrl('be_page_edit', array(
                    'id' => $page->getId()
                )));
            }
        }
        
        return $this->render('CmsBundle:Backend:pageform.html.twig', array(
            'isNew' => false,
            'form' => $form->createView(),
        ));
    }
    
    public function pagesDeleteAction($id)
    {
        $query = $this->get('doctrine')->getEntityManager()
            ->createQuery('DELETE FROM Vivacom\CmsBundle\Entity\Page p WHERE p.id = :id');
        
        $query->setParameters(array(
            'id' => $id
        ));
        $query->execute();
        
        return $this->redirect($this->generateUrl('be_page_list'));
    }
}