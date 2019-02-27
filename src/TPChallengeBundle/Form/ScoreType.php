<?php

namespace TPChallengeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ScoreType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickName', TextType::class, array('required' => true))
            ->add('firstName', TextType::class, array('required' => true))
            ->add('lastName', TextType::class, array('required' => true))
            ->add('email', EmailType::class, array('required' => true))
            ->add('score', IntegerType::class, array('required' => true))
            ->add('isSpecialGuest', CheckboxType::class, array('required' => false))

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => 'TPChallengeBundle\Entity\Score',
            'csrf_protection'   => false
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix() {
        return '';
    }

}
