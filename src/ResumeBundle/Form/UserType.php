<?php

namespace ResumeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
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
            ->add('firstname')
            ->add('middlename')
            ->add('lastname')
            ->add('momlastname')
            ->add('birthdate', BirthdayType::class, array(
              'attr' => array(),
              'placeholder' => array(
              'day' => 'Dia', 'month' => 'Mes', 'year' => 'Año',
                              ),
              'format' => 'dd-MM-yyyy',
              'label' => 'Fecha de Nacimiento',
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
