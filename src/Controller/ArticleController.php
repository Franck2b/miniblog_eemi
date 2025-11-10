<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articles')]
class ArticleController extends AbstractController
{
    #[Route('', name: 'app_articles')]
    public function index(ArticleRepository $articleRepository, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 9;
        $sort = $request->query->get('sort', 'date_desc');
        
        $queryBuilder = $articleRepository->createQueryBuilder('a');
        
        match ($sort) {
            'date_asc' => $queryBuilder->orderBy('a.createdAt', 'ASC'),
            'title_asc' => $queryBuilder->orderBy('a.title', 'ASC'),
            'title_desc' => $queryBuilder->orderBy('a.title', 'DESC'),
            default => $queryBuilder->orderBy('a.createdAt', 'DESC'),
        };
        
        $articles = $queryBuilder
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit)
            ->getQuery()
            ->getResult();
        
        $totalPages = ceil($articleRepository->count([]) / $limit);

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'currentSort' => $sort,
        ]);
    }

    #[Route('/{slug}', name: 'app_article_show')]
    public function show(Article $article): Response
    {
        $commentForm = $this->createForm(\App\Form\CommentType::class, new \App\Entity\Comment(), [
            'action' => $this->generateUrl('app_comment_add', ['id' => $article->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}

