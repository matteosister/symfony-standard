<?php

/*
 * matteosister
 * just for fun...
 */

namespace Vivacom\CmsBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;

/**
 * @orm:Entity
 * @orm:Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:generatedValue(strategy="IDENTITY")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
}