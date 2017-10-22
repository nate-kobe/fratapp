<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CultePresidentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('president', EntityType::class, array(
                    'class' => 'AppBundle:User',
                    'choices' => $options['user_group']->getUsers(),
                    'choice_label' => 'firstName'))
                ->add('preacher', TextType::class, array('label' => 'Prédicateur(se) '), array('required' => false))
                ->add('sermon', TextType::class, array('label' => 'Prédication '), array('required' => false))
                ->add('structure', TextareaType::class, array('required' => false))
                ->add('infos', TextareaType::class, array('required' => false))
                ->add('stScene', CheckboxType::class, array('label' => 'Sainte-cène', 'required' => false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Culte',
            'user_group' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_culte';
    }


}
