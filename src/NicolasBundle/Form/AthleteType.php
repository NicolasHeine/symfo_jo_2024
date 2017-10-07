<?php

namespace NicolasBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
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
            ->add('lastName',TextType::class, array('label' => 'table.athlete.last_name', 'translation_domain' => 'messages'))
            ->add('firstName',TextType::class, array('label' => 'table.athlete.first_name', 'translation_domain' => 'messages'))
            ->add('birthDate', BirthdayType::class, array('label' => 'table.athlete.birth_date', 'translation_domain' => 'messages'))
            ->add('picture', FileType::class, array('label' => 'table.athlete.picture', 'data_class' => null, 'translation_domain' => 'messages'))
            ->add('discipline', EntityType::class, array('label' => 'table.athlete.discipline', 'class' => 'NicolasBundle:Discipline', 'choice_label' => 'name', 'translation_domain' => 'messages'))
            ->add('pays', EntityType::class, array('label' => 'table.athlete.pays', 'class' => 'NicolasBundle:Pays', 'choice_label' => 'name', 'translation_domain' => 'messages'));
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
