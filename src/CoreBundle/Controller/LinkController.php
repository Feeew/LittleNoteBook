<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Link;
use CoreBundle\Form\LinkType;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CoreBundle\Entity\Notification;
use CoreBundle\Enum\NotificationTypeEnum;
use UserBundle\Entity\User;

class LinkController extends Controller
{
    public function indexAction()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('CoreBundle:Link');
        
        $listLink = $repository->findByUser($this->getUser());
        
        return $this->render('CoreBundle:Link:index.html.twig', array('listLink' => $listLink));
    }
    
    public function addAction(Request $request)
    {
        $link = new Link();
        $form   = $this->createForm(LinkType::class, $link, array('user'=>$this->getUser()));
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('link.add_success'));
            
            return $this->redirectToRoute('core_links', array());
        };
        
        return $this->render('CoreBundle:Link:add_update.html.twig', array(
            'form' => $form->createView(),
            'submitButtonLabel' => 'form.submit.add'
        ));
    }
    
    public function updateAction(Request $request, $id){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('CoreBundle:Link');
        
        $link = $repository->findByIdWithUser($id);
        
        $form   = $this->createForm(LinkType::class, $link, array('user'=>$this->getUser()));
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('link.update_success'));
            
            return $this->redirectToRoute('core_links');
        };
        
        return $this->render('CoreBundle:Link:add_update.html.twig', array(
            'form' => $form->createView(),
            'submitButtonLabel' => 'form.submit.update'
        ));
    }
    
    public function deleteAction(Request $request, $id){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('CoreBundle:Link');
        
        $link = $repository->findOneById($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($link);
        $em->flush();
                
        $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('link.delete_success'));
        
        return $this->redirectToRoute('core_links');
    }
    
    public function copyAction(Request $request, Link $link, $category = null){
        
        $em = $this->getDoctrine()->getManager();
       
        $new_link = clone $link;
        
        if(null === $category){ //On copie juste un lien
            
            $new_link->setCategory();
            
            $form   = $this->createForm(LinkType::class, $new_link, array('user'=>$this->getUser()));
            
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($new_link);
                $em->flush();
                
                $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('link.copy_success'));
                
                return $this->redirectToRoute('core_links');
            };
            
            return $this->render('CoreBundle:Link:add_update.html.twig', array(
                'form' => $form->createView(),
                'submitButtonLabel' => 'form.submit.add'
            ));
        }
        else{ //On copie une catégorie entière
            
            $new_link->setCategory($category);
            
            $em->persist($new_link);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('link.copy_success'));
            
            return $this->redirectToRoute('core_homepage');
        }
    }
    
    /**
     * @Route()()   ("/share/link/{id_link}/user/{id_user}")
     * @ParamConverter("link", options={"id" = "id_link"})
     * @ParamConverter("user", options={"id" = "id_user"})
     */
    public function shareAction(Request $request, Link $link, User $user){
        $notification = new Notification();
        $notification->setCreationDate(new \DateTime());
        $notification->setTypemessage(NotificationTypeEnum::TYPE_SHARE);
        $notification->setEntity($link->getId());
        $notification->setUserReceiver($user);
        $notification->setUserSender($this->getUser());
        $classname = explode('\\', Link::class);
        $classname = array_pop($classname);
        $notification->setEntitytype($classname);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($notification);
        $em->flush();
        
        $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('link.share_success'));
        
        return $this->redirectToRoute('core_homepage');
    }
}
