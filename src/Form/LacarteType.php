<?php

namespace App\Form;

use App\Entity\Lacarte;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class LacarteType extends AbstractType
{
    private $categories;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categories = $categorieRepository->findAll();
    }
    

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categories = [];
        foreach ($this->categories as $categorie) {
            $categories[$categorie->getCategorieName()] = $categorie;
        }

        $builder
            ->add('NomDuPlat', TextType::class)
            ->add('ingredient', TextType::class)
            ->add('prix', TextType::class)
            ->add('poids', IntegerType::class)
            ->add('unite', ChoiceType::class, [
                'label' => "Unité de mesure",
                "choices" => [
                    "g" => "g",
                    "cl" => "cl",
                ],
            ])
            ->add('uploadImage', FileType::class, [
                // 'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un fichier valide (JPEG, PNG ou GIF)',
                    ])
                ],
            ])
            ->add('categorie', ChoiceType::class, [
                'choices' => $categories,
                'choice_label' => 'CategorieName',
            ])
            ->add('Envoyer', SubmitType::class);
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lacarte::class,
        ]);
    }
}