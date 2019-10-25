<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppBookController extends AbstractController
{
    /**
     * @Route("/app/book", name="app_book")
     */
    public function index()
    {
        return $this->render('app_book/index.html.twig', [
            'controller_name' => 'AppBookController',
        ]);
    }

    /**
     * @Route("/books", name="books")
     */
    public function books()
    {

        $repo = $this->getDoctrine()->getRepository(Book::class);

        $books = $repo->findAll();

        return $this->render('app_book/books.html.twig', [
            'books' => $books,
        ]);
    }
}
