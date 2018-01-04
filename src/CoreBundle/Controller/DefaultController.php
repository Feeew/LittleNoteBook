<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction(User $user = null)
    {
        $rep_category = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('CoreBundle:Category');
        
        //Cas où on affiche l'index d'un autre user
        if (null == $user){
            $user = $this->getUser();
        }
        
        $listCategory = array();
        $username=null;
        
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $listCategory = $rep_category->findByUserWithJointure($user);
            
            $username = $user->getUsername();
        }
        
        return $this->render('CoreBundle:Default:index.html.twig', array(
            'listCategory'=>$listCategory,
            'username'=>$username,
        ));
    }
}
