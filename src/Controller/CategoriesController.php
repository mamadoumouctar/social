<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('', name: 'categorie.index', methods: ['GET'])]
    public function index(CategorieRepository $repository): Response
    {
        return $this->render('categories/index.html.twig', [
            'categories' => $repository->findAll()
        ]);
    }

    #[Route('/{slug<.*>}-{id<\d+>}', name: 'categorie.show', methods: ['GET'])]
    public function show(int $id, string $slug, CategorieRepository $repository): Response
    {
        $categorie = $repository->find($id);
        if($categorie->getSlug() !== $slug) return $this->redirectToRoute('categorie.show', [
            'id' => $categorie->getId(),
            'slug' => $categorie->getSlug()
        ]);
        return $this->render('categories/show.html.twig', compact('categorie'));
    }
}
