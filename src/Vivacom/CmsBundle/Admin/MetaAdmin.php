<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Vivacom\CmsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class MetaAdmin extends Admin {
    protected $baseRouteName = 'meta';
    protected $baseRoutePattern = 'meta';


    protected $list = array(
        'name' => array('identifier' => true),
        'content',
    );

    protected $form = array(
        'name',
        'content',
    );

    protected $filter = array(
        'name',
        'content',
    );

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('content');
    }
}