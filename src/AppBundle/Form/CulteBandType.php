<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CulteBandType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('band', EntityType::class, array(
            'label' => 'Groupe',
            // query choices from this entity
            'class' => 'AppBundle:User',

            // use the User.username property as the visible option string
            'choices' => $options['user_group']->getUsers(),
            'choice_label' => 'firstName'))
            ->add('bandRehearsal', TimeType::class, array('label' => 'Heure d\'arrivée du groupe'))
            ->add('worshipStructure')
            ->add('instrumentsStr', CollectionType::class, array(
                'label' => 'Composition du groupe',
                'entry_type'   => ChoiceType::class,
                'allow_add' => true,
                'prototype' => true,
                'prototype_data'=> '1',
                'entry_options'  => array(
                    'choices' => $options['instruments'],
                    'choice_label' => 'name'
                    )
            ))

            /* ->add('instruments', CollectionType::class, array(
                'label' => 'Composition du groupe',
                'entry_type'   => EntityType::class,
                'allow_add' => true,
                'prototype' => true,
                'prototype_data'=> '1',

                'entry_options'  => array(
                    'class' => 'AppBundle:Instrument',
                    'choice_label' => 'name')
            )) */
            ->add('songs', CollectionType::class, array(
                'label' => 'Chants',
                'entry_type'   => EntityType::class,
                'allow_add' => true,
                'prototype' => true,
                'prototype_data'=> '1',

                'entry_options'  => array(
                    'class' => 'AppBundle:Song',
                    'choice_label' => 'title')
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Culte',
            'mapped' => false,
            'user_group' => null,
            'instruments' => null,
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
