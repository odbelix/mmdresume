<?php

namespace ResumeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class TechmidType extends AbstractType
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
                'label' => 'Fecha de Inicio',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                'class' => 'form-control input-inline datepicker',
                'data-provide' => 'datepicker',
                'data-date-format' => 'dd-mm-yyyy'
                )
            ))
            ->add('endjob', DateType::class, array(
                'label' => 'Fecha de Termino',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                'class' => 'form-control input-inline datepicker',
                'data-provide' => 'datepicker',
                'data-date-format' => 'dd-mm-yyyy',
                'language' => 'es'
                )
            ))
            ->add('hours',IntegerType::class, array('label' => 'Horas semanales',
                  'attr' => array('class' => 'form-control','min' => '1','max' => '56','placeholder' => "Ingresar horas semanales")
                ))
            //->add('username')
            ->add('profession',EntityType::class, array('label' => 'Título de Técnico de Nivel Medio',
                  'class' => 'ResumeBundle:Profession',
                  'placeholder' => "Selecciona título de técnico de nivel medio",
                  'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('et')
                        ->where('et.usertype = :ut')
                        ->setParameter('ut', 3)
                        ->orderby('et.name','ASC');
                   },
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
