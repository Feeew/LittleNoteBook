<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Link
 *
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\LinkRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Link
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    
    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Category", inversedBy="links")
     */
    private $category;


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
     * Set name
     *
     * @param string $name
     *
     * @return Link
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
     * Set url
     *
     * @param string $url
     *
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Set category
     *
     * @param category Category
     *
     * @return Link
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Categorie
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function increaseCategoryNbLink()
    {
        $this->getCategory()->increaseNbLinks();
    }
    
    /**
     * @ORM\PreRemove
     */
    public function decreaseCategoryNbLink()
    {
        $this->getCategory()->decreaseNbLinks();
    }
    
    public function toString(){
        return $this->getId() . " : " . $this->getName();
    }
}