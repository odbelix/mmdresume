<?php

namespace ResumeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class WorkplaceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, array('label' => 'Nombre',
                  'attr' => array('class' => 'form-control')
                ))
            ->add('address',TextType::class, array('label' => 'Dirección',
                  'attr' => array('class' => 'form-control')
                ))
            ->add('responsable',TextType::class, array('label' => 'Director',
                  'required' => false,
                  'attr' => array('class' => 'form-control')
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ResumeBundle\Entity\Workplace'
        ));
    }
}
