<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/comments')]
class CommentController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/article/{id}/add', name: 'app_comment_add', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function add(Request $request, Article $article): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setArticle($article);
            $comment->setAuthor($this->getUser());

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a été publié avec succès !');
        } else {
            $this->addFlash('error', 'Erreur lors de la publication du commentaire. Veuillez réessayer.');
        }

        return $this->redirectToRoute('app_article_show', ['slug' => $article->getSlug()]);
    }

    #[Route('/{id}/delete', name: 'app_comment_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Comment $comment): Response
    {
        if ($comment->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas la permission de supprimer ce commentaire.');
            return $this->redirectToRoute('app_article_show', ['slug' => $comment->getArticle()->getSlug()]);
        }

        if ($this->isCsrfTokenValid('delete_comment' . $comment->getId(), $request->request->get('_token'))) {
            $articleSlug = $comment->getArticle()->getSlug();
            
            $this->entityManager->remove($comment);
            $this->entityManager->flush();

            $this->addFlash('success', 'Commentaire supprimé avec succès !');
            
            return $this->redirectToRoute('app_article_show', ['slug' => $articleSlug]);
        }

        $this->addFlash('error', 'Token CSRF invalide.');
        return $this->redirectToRoute('app_article_show', ['slug' => $comment->getArticle()->getSlug()]);
    }
}

