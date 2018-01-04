<?php
namespace CoreBundle\DoctrineListener;

use CoreBundle\Entity\Link;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;

class LinkUpdateListener
{   
    public function onFlush(OnFlushEventArgs $event)
    {        
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();
        
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if (!$entity instanceof Link) {
                return;
            }
            $changeSet = $uow->getEntityChangeSet($entity);
            
            if(array_key_exists('category', $changeSet) === false){
                return;
            }
            
            $oldCategory = $changeSet['category'][0];
            $oldCategory->decreaseNbLinks();
            
            $newCategory = $changeSet['category'][1];
            $newCategory->increaseNbLinks();
            
            $classMetadata = $em->getClassMetadata('CoreBundle\Entity\Category');
            $uow->computeChangeSet($classMetadata, $oldCategory);
            $uow->computeChangeSet($classMetadata, $newCategory);
        }
        
    }
}