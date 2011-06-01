<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

/**
 * @author matteosister
 */

namespace Vivacom\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PageType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
        $builder->add('url', null, array('required' => false));
        $builder->add('content');
        //$builder->add('metas', 'collection', array('required' => false));
    }
}