<?php

namespace ResumeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfessionType extends AbstractType
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
            ->add('usertype',EntityType::class, array('label' => 'Tipo de Postulante',
                  'class' => 'ResumeBundle:Usertype',
                  'placeholder' => "Selecciona un tipo de postulante",
                  'attr' => array('class' => 'form-control')
                ));
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ResumeBundle\Entity\Profession'
        ));
    }
}
