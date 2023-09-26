<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\ArticleType;
use App\Form\CommentFormType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isNull;

#[Route('/article')]
class ArticleController extends AbstractController
{

    #[Route('', name: 'article.index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findArticlesWithCategories(),
        ]);
    }

    #[Route('/new', name: 'article.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', message: "impossible");
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $entityManager->persist($article->setAutor($user));
            $entityManager->flush();

            return $this->redirectToRoute('article.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{slug<.*>}-{id<\d+>}', name: 'article.show', methods: ['GET', 'POST'])]
    public function show(string $slug, int $id, ArticleRepository $repository, Request $request, EntityManagerInterface $em): Response
    {
        $article = $repository->findArticleDetail($id);

        if(!$article) throw $this->createNotFoundException();

        if($article->getSlug() !== $slug) return $this->redirectToRoute('article.show', [
            'id' => $article->getId(),
            'slug' => $article->getSlug()
        ]);
        $comment = new Commentaire();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $article->addCommentaire($comment);
            $em->flush();
            return $this->redirectToRoute('article.show', [
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ]);
        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'article.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', message: "impossible");
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $user = $this->getUser();
            // $article->setAutor($user);
            $entityManager->flush();

            return $this->redirectToRoute('article.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'article.delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', message: "impossible");
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article.index', [], Response::HTTP_SEE_OTHER);
    }
}
