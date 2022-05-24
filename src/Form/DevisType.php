<?php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\Client;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\TextFilterType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('refDevis')
            ->add('dateDevis',DateType::class)
            ->add('messageDevis',TextareaType::class)
           
            ->add('clientt',TextType::class,['mapped'=>false] //EntityType::class, ,'required'   => true[
            //->add('client', AutocompleteType::class, ['class' => 'Client']

               
             //EntityType::class, [    
                // looks for choices from this entity
              //  'class' => Client::class,
            
                // uses the User.username property as the visible option string
              //  'choice_label' => 'emailClient',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
           // ]
            )
           // ->add('iid',TextType::class,['mapped'=>false])
            //->add('modalitesPaiementDevis')
            ->add('modalitesPaiementDevis', ChoiceType::class, [
                'choices' => [
                    'Espèces' => 'espèces',
                    'Chèque' => 'chèque',
                    'Virement' => 'virement',
                ]
                
            ])
            ->add('delaiDevis') 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
