<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('CoreBundle:Category');
        
        $listCategory = array();
        
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $listCategory = $repository->findByUserWithLinks($this->getUser());
        }
        
        return $this->render('CoreBundle:Default:index.html.twig', array('listCategory'=>$listCategory));
    }
}
