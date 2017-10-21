<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CulteBandType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('band', EntityType::class, array(
            // query choices from this entity
            'class' => 'AppBundle:User',

            // use the User.username property as the visible option string
            'choices' => $options['user_group']->getUsers(),
            'choice_label' => 'firstName',

            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
        ));
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