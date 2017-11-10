<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Link;
use CoreBundle\Form\LinkType;

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
        
        return $this->render('CoreBundle:Link:add.html.twig', array(
            'form' => $form->createView(),
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
            
            //return $this->redirectToRoute('core_links', array());
            ////////////////////////////////
            $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('CoreBundle:Link');
            
            $listLink = $repository->findByUser($this->getUser());
            
            return $this->render('CoreBundle:Link:index.html.twig', array('listLink' => $listLink));
            /////////////////////////////////////////////////
        };
                
        $form = $this->createForm(LinkType::class, $link, array('user'=>$this->getUser()));
        
        return $this->render('CoreBundle:Link:update.html.twig', array('form' => $form->createView()));
    }
    
    public function deleteAction(Request $request, $id){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('CoreBundle:Link');
        
        $link = $repository->findById($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($link);
                
        $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('link.delete_success'));
        
        return $this->redirectToRoute('core_links');
    }
}
