<?php
namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use CoreBundle\Repository\CategoryRepository;
use UserBundle\Entity\User;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        
        $builder
        ->add('name', TextType::class, array())
        ->add('url', UrlType::class, array())
        ->add('category', EntityType::class, array(
            'class'        => 'CoreBundle:Category',
            'choice_label' => 'display',
            'query_builder' => function(CategoryRepository $repository) use ($user){
                return $repository->findByUserQB($user);
            }
        ))
        ->add('save', SubmitType::class, array(
            'attr' => array('class' => 'form_submit'),
        ));;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Link'
        ));
        
        $resolver->setRequired('user');
    }
}