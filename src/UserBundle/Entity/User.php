<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Category", mappedBy="user")
     */
    private $categories;
    
    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Notification", mappedBy="userReceiver")
     */
    private $notifications;
}