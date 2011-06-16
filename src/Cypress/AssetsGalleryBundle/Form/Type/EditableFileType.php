<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Tests\Component\Form\FormInterface;

class EditableFileType extends AbstractType
{
    public function getParent(array $options)
    {
        return $options['parent'];;
    }

    public function getName()
    {
        return 'gallery_asset_editable_file';
    }
}