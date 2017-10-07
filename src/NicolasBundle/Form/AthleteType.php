<?php

namespace NicolasBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AthleteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName',TextType::class, array('label' => 'Nom'))
            ->add('firstName',TextType::class, array('label' => 'Prénom'))
            ->add('birthDate', DateType::class, array('label' => 'Date de naissance'))
            ->add('picture', FileType::class, array('label' => 'Image de profil'))
            ->add('discipline', EntityType::class, array('label' => 'Discipline de l\'athlète', 'class' => 'NicolasBundle:Discipline', 'choice_label' => 'name'))
            ->add('pays', EntityType::class, array('label' => 'Pays de l\'athlete', 'class' => 'NicolasBundle:Pays', 'choice_label' => 'name'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NicolasBundle\Entity\Athlete'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nicolasbundle_athlete';
    }


}
