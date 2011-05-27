<?php

/*
 * matteosister
 * just for fun...
 */

namespace Vivacom\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Vivacom\CmsBundle\Entity\Page;

class BackendController  extends Controller 
{
    public function dashboardAction()
    {
        return $this->render('CmsBundle:Backend:dashboard.html.twig');
    }
    
    public function pagesAction()
    {
        return $this->render('CmsBundle:Backend:pages.html.twig');
    }
    
    public function pagesNewAction()
    {
        $page = new Page();
        $factory = $this->get('form.factory');
        var_dump($factory);
        
        return $this->render('CmsBundle:Backend:pagesnew.html.twig', array(
            'form' => ''
        ));
    }
}