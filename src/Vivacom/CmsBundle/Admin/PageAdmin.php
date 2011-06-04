<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Vivacom\CmsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class PageAdmin extends Admin {
    protected $baseRouteName = 'page';
    protected $baseRoutePattern = 'page';


    protected $list = array(
        'name' => array('identifier' => true),
        'url',
    );

    protected $form = array(
        'name',
        'url',
        'content',
    );

    protected $filter = array(
        'name',
    );

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
          ->add('name')
          ->add('url', array('required' => false))
          ->add('content');
    }
}

