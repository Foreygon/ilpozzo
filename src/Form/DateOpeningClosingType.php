<?php

namespace App\Form;

use App\Entity\DateOpeningClosingTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DateOpeningClosingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day', ChoiceType::class, [
                "choices" => [
                    "Lundi" => "lundi",
                    "Mardi" => "mardi",
                    "Mercredi" => "mercredi",
                    "Jeudi" => "jeudi",
                    "Vendredi" => "vendredi",
                    "Samedi" => "samedi",
                    "Dimanche" => "dimanche",
                ],
                "placeholder" => "-Selectionné le jour-",
                'label' => "Jour * "
            ])
            ->add('opening_time_moon', TimeType::class, [
                'label' => "Horaire d'ouvertue le midi *",
                'empty_data' => "fermé",
                
                'minutes' => [0, 15, 30, 45],
                'widget' => 'choice',

            ])
            ->add('closing_time_moon', TimeType::class, [
                'label' => "Horaire de fermeture le midi *",
                'empty_data' => "fermé",
                
                'minutes' => [0, 15, 30, 45],
                'widget' => 'choice',

            ])
            ->add('opening_time_evening', TimeType::class, [
                'label' => "Horaire d'ouvertue le soir *",
                'empty_data' => "fermé",
                
                'minutes' => [0, 15, 30, 45],
                'widget' => 'choice',
            ])
            ->add('closing_time_evening', TimeType::class, [
                'label' => "Horaire de fermeture le soir *",
                'empty_data' => "fermé",
                
                'minutes' => [0, 15, 30, 45],
                'widget' => 'choice',

            ])
            ->add("Envoyer", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DateOpeningClosingTime::class,
        ]);
    }
}
