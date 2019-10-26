<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
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
    public function books(BookRepository $repo)
    {
        $books = $repo->findAll();

        return $this->render('app_book/books.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/book/{id}", name="showbook")
     */
    function showbook($id)
    {
        $repo = $this->getDoctrine()->getRepository(Book::class);

        $book = $repo->find($id);

        return $this->render('app_book/showbook.html.twig',[
            'book' => $book,
        ]);
    }
}
