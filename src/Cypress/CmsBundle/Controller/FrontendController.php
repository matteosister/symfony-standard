<?php

namespace Cypress\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
    /**
     * @extra:Route("/", name="homepage")
     * @extra:Template()
     */
    public function homepageAction()
    {
        return $this->render('CypressCmsBundle:Frontend:homepage.html.twig');
    }
}
