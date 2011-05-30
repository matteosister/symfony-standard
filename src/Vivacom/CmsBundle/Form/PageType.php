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

class PageType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
        $builder->add('url');
    }
}