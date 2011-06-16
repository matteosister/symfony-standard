<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GalleryAssetType extends AbstractType
{
    
    /**
     * Build asset form
     * @param FormBuilder $builder
     * @param array $options 
     */
    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('name')
                ->add('filename', 'file')
                ->add('description', 'textarea', array('required' => false))
                ->add('folder');
    }
}