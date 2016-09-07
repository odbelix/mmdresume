<?php

namespace ResumeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rut')
            ->add('firstname')
            ->add('middlename')
            ->add('lastname')
            ->add('momlastname')
            ->add('birthdate', DateType::class, array(
                'label' => 'Fecha de Nacimiento',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                'class' => 'form-control input-inline datepicker',
                'data-provide' => 'datepicker',
                'data-date-format' => 'dd-mm-yyyy'
                )
            ))
            ->add('phone')
            ->add('celphone')
            ->add('address')
            ->add('city')
            ->add('gender', ChoiceType::class, array(
              'attr' => array(),
              'choices'  => array('Femenino' => 'Femenino', 'Masculino' => 'Masculino'),
              'label' => 'Selecciona tu género',
              'placeholder' => "Selecciona tu género"
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ResumeBundle\Entity\User'
        ));
    }
}
