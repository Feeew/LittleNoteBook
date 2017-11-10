<?php
namespace CoreBundle\DoctrineListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use CoreBundle\Entity\Link;
use Doctrine\ORM\EntityManager;

class LinkUpdateListener
{   
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getEntity();
        
        if (!$entity instanceof Link) {
            return;
        }
        
        if ($event->hasChangedField('category')) {
            $em = $event->getEntityManager();
            
            $oldCategory = $event->getOldValue('category');
            $oldCategory->decreaseNbLinks();
            $em->persist($oldCategory);
            
            $newCategory = $event->getNewValue('category');
            $newCategory->increaseNbLinks();
            //$em->persist($newCategory);
            
            $em->flush();
        }
        
    }
}