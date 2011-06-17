<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Cypress\AssetsGalleryBundle\Entity\GalleryFolderRepository;
use Doctrine\ORM\EntityRepository;


class GalleryFolderType extends AbstractType
{
    /**
     * Build folder form
     * @param FormBuilder $builder
     * @param array $options 
     */
    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('name');
        
        $builder->add('parent', 'entity', array(
            'required' => true,
            'class'    => 'Cypress\\AssetsGalleryBundle\\Entity\\GalleryFolder',
            'property' => 'indented_name',
            'query_builder' => function(EntityRepository $er) {
                return $er->getTreeOrderQueryBuilder();
            }
        ));
        
        
    }
}