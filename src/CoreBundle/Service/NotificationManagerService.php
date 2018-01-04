<?php

namespace CoreBundle\Service;

use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;

class NotificationManagerService
{
    
    protected $em = null;
    
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    
    public function getNotifications(User $user)
    {
        $rep_notification = $this->em->getRepository('CoreBundle:Notification');
        
        $listNotifications = $rep_notification->findNotifByUser($user);
        
        foreach($listNotifications as $key=>$value){
            $rep_temp = $this->em->getRepository('CoreBundle:'.$value->getEntitytype());
            
            $value->setEntity($rep_temp->findOneById($value->getEntity()));
        }
        
        return $listNotifications;
    }
}
