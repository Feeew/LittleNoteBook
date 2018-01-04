<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @ORM\Column(name="fileName", type="string", length=500)
     */
    private $fileName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;
    
    private $file;
    private $tempFileName;
    
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
     * @return Image
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Image
     */
    public function setFilename($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->fileName;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Image
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
     * Set category
     *
     * @param string $category
     *
     * @return Image
     */
    public function setCategory($category)
    {
        $this->category = $category;
        
        return $this;
    }
    
    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    public function getFile()
    {
        return $this->file;
    }
    
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }
        if(!is_null($this->fileName)){
            $this->tempFileName = $this->getUploadRootDir().'/'.$this->fileName;
        }
        $this->creationDate = new \DateTime();
        $this->fileName = uniqid('category_').'.'.$this->file->guessExtension();
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $this->file) {
            return;
        }
        
        if (file_exists($this->tempFileName)) {
            // On supprime le fichier
            unlink($this->tempFileName);
        }
        
        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move($this->getUploadRootDir(), $this->fileName);
    }
    
    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
        $this->tempFileName = $this->getUploadRootDir().$this->fileName;
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
        if (file_exists($this->tempFileName)) {
            // On supprime le fichier
            unlink($this->tempFileName);
        }
    }
    
    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'img/category/';
    }
    
    public function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
    
    public function clone(){
        $image = new Image();
        $image->setFilename(uniqid('category_').'.'.explode('.', $this->fileName)[1])->setCreationDate(new \DateTime());
        copy($this->getUploadRootDir() .  $this->fileName, $this->getUploadRootDir() .  $image->getFilename());
        
        return $image;
    }
}