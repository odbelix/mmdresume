<?php

namespace ResumeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class JobType extends AbstractType
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
            ->add('detail',TextareaType::class, array('label' => 'Detalle',
              'attr' => array('class' => 'tinymce','class' => 'textbox','class' => 'form-control')))
            ->add('startjob', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                'class' => 'form-control input-inline datepicker',
                'data-provide' => 'datepicker',
                'data-date-format' => 'dd-mm-yyyy'
                )
            ))
            ->add('endjob', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                'class' => 'form-control input-inline datepicker',
                'data-provide' => 'datepicker',
                'data-date-format' => 'dd-mm-yyyy',
                'language' => 'es'
                )
            ))
            ->add('hours',TextType::class, array('label' => 'Horas semanales',
                  'attr' => array('class' => 'form-control')
                ))
            //->add('username')
            ->add('profession',TextType::class, array('label' => 'Título/Profesión',
                  'attr' => array('class' => 'form-control')
                ))
            ->add('workplace',EntityType::class, array('label' => 'Lugar de Trabajo',
                  'class' => 'ResumeBundle:Workplace',
                  'placeholder' => "Selecciona el lugar de Trabajo",
                  'attr' => array('class' => 'form-control')
                ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ResumeBundle\Entity\Job'
        ));
    }
}
