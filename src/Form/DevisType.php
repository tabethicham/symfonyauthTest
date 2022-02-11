<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('refDevis')
            ->add('dateDevis')
            ->add('messageDevis')
            ->add('modalitesPaiementDevis')
            ->add('delaiDevis')
            ->add('client', EntityType::class, [
                // looks for choices from this entity
                'class' => Client::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'emailClient',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
