<?php

namespace RecBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ServType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('body')
            ->add('price')
            ->add('top')
            ->add('big')
            ->add('img',FileType::class)
            ->add('tags', CollectionType::class, array(
                'label'=>false,
                'entry_type' => ServTagsType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true
            ))
            ->add('save',SubmitType::class)
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RecBundle\Entity\Serv'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'recbundle_serv';
    }


}
