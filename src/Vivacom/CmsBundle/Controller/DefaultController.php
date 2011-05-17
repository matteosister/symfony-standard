<?php

namespace Vivacom\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CmsBundle:Default:index.html.twig');
    }
    
    public function pageAction()
    {
        return $this->render('CmsBundle:Default:page.html.twig');
    }
}
