<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Notification;

class NotificationController extends Controller
{
    public function deleteAction(Request $request, Notification $notification){
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($notification);
        $em->flush();
        
        $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('notification.delete_success'));
        
        return $this->redirectToRoute('core_homepage');
    }
}
