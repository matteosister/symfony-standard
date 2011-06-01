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


class BackendController extends Controller 
{   
    public function dashboardAction()
    {
        return $this->render('CmsBundle:Backend:dashboard.html.twig');
    }
}