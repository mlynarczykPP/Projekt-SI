<?php
/**
 * Note controller.
 */

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Service\NoteService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NoteController.
 *
 * @Route("/notes")
 */
class NoteController extends AbstractController
{
    /**
     * Note service.
     *
     * @var NoteService
     */
    private NoteService $noteService;

    /**
     * NoteController constructor.
     *
     * @param NoteService $noteService Note service
     */
    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="notes_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['tags_id'] = $request->query->getInt('filters_tags_id');

        $pagination = $this->noteService->createPaginatedList(
            $request->query->getInt('page', 1),
            $this->getUser(),
            $filters
        );

        return $this->render(
            'notes/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Note $note Note entity
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
            ['notes' => $note]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="notes_create",
     * )
     */
    public function create(Request $request): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $note->setAuthor($this->getUser());
            $this->noteService->save($note);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('notes_index');
        }

        return $this->render(
            'notes/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request    HTTP request
     * @param Note     $note       Note entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="notes_edit",
     * )
     */
    public function edit(Request $request, Note $note): Response
    {
        $form = $this->createForm(NoteType::class, $note, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $note->setAuthor($this->getUser());
            $this->noteService->save($note);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('notes_index');
        }

        return $this->render(
            'notes/edit.html.twig',
            [
                'form' => $form->createView(),
                'notes' => $note,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request   $request    HTTP request
     * @param Note      $note       Note entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="notes_delete",
     * )
     */
    public function delete(Request $request, Note $note): Response
    {
        $form = $this->createForm(FormType::class, $note, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteService->delete($note);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('notes_index');
        }

        return $this->render(
            'notes/delete.html.twig',
            [
                'form' => $form->createView(),
                'notes' => $note,
            ]
        );
    }
}