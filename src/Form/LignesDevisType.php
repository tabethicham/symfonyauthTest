<?php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\LignesDevis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LignesDevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('quantite')
            ->add('prixUnitHT')
            //->add('devis')
            ->add('deviss',TextType::class,['mapped'=>false])
           /* ->add('devis',EntityType::class, [
                
                    // looks for choices from this entity
                    'class' => Devis::class,
                
                    // uses the User.username property as the visible option string
                    'choice_label' => 'refDevis',
                
                    // used to render a select box, check boxes or radios
                    // 'multiple' => true,
                    // 'expanded' => true,
                ])*/
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LignesDevis::class,
        ]);
    }
}
