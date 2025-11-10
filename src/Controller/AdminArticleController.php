<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/articles')]
#[IsGranted('ROLE_USER')]
class AdminArticleController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SluggerInterface $slugger
    ) {
    }

    #[Route('', name: 'app_admin_article_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $articles = $articleRepository->findBy([], ['createdAt' => 'DESC']);
        } else {
            $articles = $articleRepository->findBy(
                ['author' => $this->getUser()],
                ['createdAt' => 'DESC']
            );
        }

        return $this->render('admin/article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/new', name: 'app_admin_article_new')]
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setSlug(strtolower($this->slugger->slug($article->getTitle())));
            $article->setAuthor($this->getUser());

            $this->entityManager->persist($article);
            $this->entityManager->flush();

            $this->addFlash('success', 'Article créé avec succès !');

            return $this->redirectToRoute('app_admin_article_index');
        }

        return $this->render('admin/article/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_article_edit')]
    public function edit(Request $request, Article $article): Response
    {
        if (!$this->isGranted('ARTICLE_EDIT', $article)) {
            $this->addFlash('error', 'Vous n\'avez pas la permission de modifier cet article.');
            return $this->redirectToRoute('app_admin_article_index');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setSlug(strtolower($this->slugger->slug($article->getTitle())));

            $this->entityManager->flush();

            $this->addFlash('success', 'Article modifié avec succès !');

            return $this->redirectToRoute('app_admin_article_index');
        }

        return $this->render('admin/article/edit.html.twig', [
            'form' => $form,
            'article' => $article,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article): Response
    {
        if (!$this->isGranted('ARTICLE_DELETE', $article)) {
            $this->addFlash('error', 'Vous n\'avez pas la permission de supprimer cet article.');
            return $this->redirectToRoute('app_admin_article_index');
        }

        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($article);
            $this->entityManager->flush();

            $this->addFlash('success', 'Article supprimé avec succès !');
        }

        return $this->redirectToRoute('app_admin_article_index');
    }
}

