<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Link
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="typemessage", type="string", length=255)
     */
    private $typemessage;

    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="notifications")
     */
    private $userReceiver;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $userSender;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="entityType", type="string", length=255)
     */
    private $entityType;
    
    /**
     * @var int
     *
     * @ORM\Column(name="entity", type="integer")
     */
    private $entity;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get typemessage
     *
     * @return string
     */
    public function getTypemessage()
    {
        return $this->typemessage;
    }
    

    /**
     * Set typemessage
     *
     * @param string $typemessage
     *
     * @return Notification
     */
    public function setTypemessage($typemessage)
    {
        $this->typemessage = $typemessage;

        return $this;
    }
    
    /**
     * Get user receiver id
     *
     * @return User
     */
    public function getUserReceiver()
    {
        return $this->userReceiver;
    }
    
    /**
     * Set user receiver id
     *
     * @return User
     */
    public function setUserReceiver($user)
    {
        $this->userReceiver = $user;
        
        return $this;
    }
    
    /**
     * Get user sender id
     *
     * @return User
     */
    public function getUserSender()
    {
        return $this->userSender;
    }
    
    /**
     * Set user sender id
     *
     * @return User
     */
    public function setUserSender($user)
    {
        $this->userSender = $user;
        
        return $this;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Notification
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        
        return $this;
    }
    
    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    
    /**
     * Get $entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    
    /**
     * Set entity
     *
     * @param int $entity
     *
     * @return Notification
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        
        return $this;
    }
    
    /**
     * Get $entityType
     *
     * @return string
     */
    public function getEntitytype()
    {
        return $this->entityType;
    }
    
    
    /**
     * Set message
     *
     * @param string $entityType
     *
     * @return Notification
     */
    public function setEntitytype($entityType)
    {
        $this->entityType = strtolower($entityType);
        
        return $this;
    }
}