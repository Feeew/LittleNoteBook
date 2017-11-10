<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CoreBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Form\CategoryType;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('CoreBundle:Category');
        
        $listCategory = $repository->findByUser($this->getUser());
        
        return $this->render('CoreBundle:Category:index.html.twig', array('listCategory'=>$listCategory));
    }
    
    public function addAction(Request $request)
    {
        $category = new Category();
        $form   = $this->createForm(CategoryType::class, $category);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $category->setCreationDate(new \DateTime())->setNbLinks(0)->setUtilisateur($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('category.add_success'));
            
            return $this->redirectToRoute('core_categories', array());
        };
        
        return $this->render('CoreBundle:Category:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
