<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller{
    public function listAction(){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('UserBundle:User');
        
        $listUser = $repository->findAll();
        
        return $this->render('UserBundle:Default:list.html.twig', array('listUser' => $listUser));
    }
    
    public function listajaxAction($type, $id){
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('UserBundle:User');
        
        $listUser = $repository->findAll();
        
        return $this->render('UserBundle:Default:listajax.html.twig', array('listUser' => $listUser, 'type' => $type, 'id' => $id));
    }
}