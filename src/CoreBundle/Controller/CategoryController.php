<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CoreBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Form\CategoryType;
use CoreBundle\Entity\Notification;
use UserBundle\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CoreBundle\Enum\NotificationTypeEnum;

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
        $category->setNbLinks(0);
        $category->setCreationDate(new \DateTime());
        $category->setUtilisateur($this->getUser());
        
        $form   = $this->createForm(CategoryType::class, $category);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('category.add_success'));
            
            return $this->redirectToRoute('core_categories', array());
        };
        
        return $this->render('CoreBundle:Category:add_update.html.twig', array(
            'form' => $form->createView(),
            'submitButtonLabel' => 'form.submit.add'
        ));
    }
    
    public function updateAction(Request $request, Category $category){
        
        $form   = $this->createForm(CategoryType::class, $category);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $file_submitted = !is_null($request->files->get('category')['image']['file']);
           
            if($file_submitted == TRUE){
                $category->getImage()->setCreationDate(new \DateTime());
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('category.update_success'));
            
            return $this->redirectToRoute('core_categories');
        };
        
        $fileName = null;
        
        if(!is_null($category->getImage())){
            $fileName = $category->getImage()->getFilename();
        }
        
        return $this->render('CoreBundle:Category:add_update.html.twig', array(
            'form' => $form->createView(),
            'submitButtonLabel' => 'form.submit.update',
            'fileName' => $fileName
        ));
    }
    
    public function deleteAction(Request $request, Category $category){
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        
        $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('category.delete_success'));
        
        return $this->redirectToRoute('core_categories');
    }
    
    public function copyAction(Request $request, Category $category_to_copy){
        $em = $this->getDoctrine()->getManager(); 
        
        $new_category = clone $category_to_copy;
        if(!is_null($category_to_copy->getImage())){
            $new_image = $category_to_copy->getImage()->clone();
            $new_category->setImage($new_image);
            $em->persist($new_image);
        }
        
        
        $new_category->setCreationDate(new \DateTime())->setUtilisateur($this->getUser())->setNbLinks(0);
        
        $em->persist($new_category);
        $em->flush();
        
        $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('category.copy_success'));
        
        foreach ($category_to_copy->getLinks() as $link){
            $this->forward('CoreBundle:Link:copy', array(
                'request' => $request,
                'id' => $link->getId(),
                'category' => $new_category
            ));
        }
        
        return $this->redirectToRoute('core_homepage');
    }
    
    /**
     * @Route()   ("/share/category/{id_category}/user/{id_user}")
     * @ParamConverter("category", options={"id" = "id_category"})
     * @ParamConverter("user", options={"id" = "id_user"})
     */
    public function shareAction(Request $request, Category $category, User $user){
        $notification = new Notification();
        $notification->setCreationDate(new \DateTime());
        $notification->setTypemessage(NotificationTypeEnum::TYPE_SHARE);
        $notification->setEntity($category->getId());
        $notification->setUserReceiver($user);
        $notification->setUserSender($this->getUser());
        $classname = explode('\\', Category::class);
        $classname = array_pop($classname);
        $notification->setEntitytype($classname);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($notification);
        $em->flush();
        
        $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('category.share_success'));
        
        return $this->redirectToRoute('core_homepage');
    }
}
