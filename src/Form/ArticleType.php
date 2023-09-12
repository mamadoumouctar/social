<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('contenue')
            ->add('categories', TextType::class, [
                'help' => "Ex: Categorie #1, Categorie #2, ..."
            ])
        ;

        $builder->get('categories')
            ->addModelTransformer(new CallbackTransformer(
                function (ArrayCollection|PersistentCollection $categorie): string {
                    return implode(', ', $categorie->toArray());
                }, function (string $categorie): array {
                    $categories = [];
                    $base = explode(', ', $categorie);
                    foreach ($base as $b){
                        $categories[] = (new Categorie())->setTitle($b);
                    }
                    return $categories;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
