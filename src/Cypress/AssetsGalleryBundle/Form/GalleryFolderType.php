<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GalleryFolderType extends AbstractType
{
    /**
     * Build folder form
     * @param FormBuilder $builder
     * @param array $options 
     */
    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('name');
        $builder->add('parent', null, array('required' => true));
    }
}