<?php
/**
 * Note controller.
 */

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 *
 * @Route("/notes")
 */
class NoteController extends AbstractController
{
    private NoteRepository $noteRepository;

    private PaginatorInterface  $paginator;

    /**
     * NoteController constructor.
     *
     * @param NoteRepository $noteRepository Note repository
     * @param PaginatorInterface $paginator Paginator interface
     */
    public function __construct(NoteRepository $noteRepository, PaginatorInterface $paginator)
    {
        $this->noteRepository = $noteRepository;
        $this->paginator = $paginator;
    }

    /**
     * Index action.
     *
     * @param Request $request                  HTTP request
     * @param NoteRepository $noteRepository    Note repository
     * @param PaginatorInterface $paginator     Paginator
     *
     * @return Response                         HTTP response
     *
     * @Route(
     *     "/",
     *     name="notes_index",
     * )
     */
    public function index(Request $request, NoteRepository $noteRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $noteRepository->queryAll(),
            $request->query->getInt('page', 1),
            NoteRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'notes/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param int $id   Record id
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="notes_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Note $note): Response
    {
        return $this->render(
            'notes/show.html.twig',
            ['note' => $note]
        );
    }
}