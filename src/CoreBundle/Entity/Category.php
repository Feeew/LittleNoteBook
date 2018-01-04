<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="datetime", nullable=true)
     */
    private $updateDate;

    /**
     * @var int
     *
     * @ORM\Column(name="nbLinks", type="integer")
     */
    private $nbLinks;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Link", mappedBy="category", cascade={"remove"})
     */
    private $links;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="categories")
     */
    private $user;
    
    /**
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;
    
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
     * Set id
     *
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Category
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
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Category
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set nbLinks
     *
     * @param integer $nbLinks
     *
     * @return Category
     */
    public function setNbLinks($nbLinks)
    {
        $this->nbLinks = $nbLinks;

        return $this;
    }

    /**
     * Get nbLinks
     *
     * @return int
     */
    public function getNbLinks()
    {
        return $this->nbLinks;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    
    /**
     * Get user id
     *
     * @return User
     */
    public function getUtilisateur()
    {
        return $this->user;
    }
    
    /**
     * Set user id
     *
     * @return Category
     */
    public function setUtilisateur($user)
    {
        $this->user = $user;
        
        return $this;
    }
    
    /**
     * Get image
     *
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Set image
     *
     * @return Image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
        
        return $this;
    }
    
    /**
     * Get links
     *
     * @return Links list
     */
    public function getLinks()
    {
        return $this->links;
    }
    
    /**
     * Get display
     * 
     * Sert à l'affichage (ex. pour l'ajout d'un lien)
     * 
     * @return String
     */
    public function getDisplay(){
        return $this->getName();
    }
    
    /**
     * Increase nbLinks
     * 
     * @return nothing
     */
    public function increaseNbLinks(){
        $this->nbLinks++;
    }
    
    /**
     * Decrease nbLinks
     *
     * @return nothing
     */
    public function decreaseNbLinks(){
        $this->nbLinks--;
    }
    
    public function toString(){
        return $this->getId() . " : " . $this->getName();
    }
    
}

