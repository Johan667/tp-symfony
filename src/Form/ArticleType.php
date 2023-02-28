<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Entrez un titre'
            ])
            ->add('content',TextEditorType::class, [
                'label' => 'Inserez du contenu'
            ])
            ->add('slug',TextType::class, [
                'label' => 'Quelle slug ?'
            ])
            ->add('status',NumberType::class, [
                'label' => 'Status de votre publication'
            ])
            ->add('featuredImage',FileType::class, [
                'label' => 'Inserez une image'
            ])
            ->add('category', EntityType::class, [
                'label'=>'Choisissez une categorie',
                'class' => Category::class,
            ])
            ->add('submit', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
