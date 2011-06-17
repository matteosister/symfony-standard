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

class GalleryAssetType extends AbstractType
{
    
    /**
     * Build asset form
     * @param FormBuilder $builder
     * @param array $options 
     */
    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('name')
                ->add('file')
                ->add('description', 'textarea', array('required' => false))
                ->add('folder', 'entity', array(
                    'required' => true,
                    'class'    => 'Cypress\\AssetsGalleryBundle\\Entity\\GalleryFolder',
                    'property' => 'indented_name',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                                ->orderBy('f.lft', 'ASC');
                    }
                ));
    }
}