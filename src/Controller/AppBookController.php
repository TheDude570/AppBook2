<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/book/new", name="create_book")
     * @Route("/book/{id}/edit", name="book_edit")
     */
    public function form(Book $book = null, Request $request, ObjectManager $manager)
    {
        if(!$book) {
            $book = new Book();
        }

        // $form = $this->createFormBuilder($book)

        //     ->add('title')
        //     ->add('image')
        //     ->add('shortDescription')
        //     ->add('longDescription')
        //     ->add('isbn10')
        //     ->add('isbn13')
        //     ->add('author')
        //     ->getForm();

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ) {
            if(!$book->getId()) {
                $book->setCreatedAt(new \DateTime());
            }

            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('show', [
                'id' => $book->getId()
            ]);
        }

        return $this->render('app_book/create.html.twig', [
            'form' => $form->createView(),
            'editMode' => $book->getId() !== null

        ]);
    }

    /**
     * @Route("/book/{id}", name="show")
     */
    function showbook($id)
    {
        $repo = $this->getDoctrine()->getRepository(Book::class);

        $book = $repo->find($id);

        return $this->render('app_book/showbook.html.twig', [
            'book' => $book
        ]);
    }
}
