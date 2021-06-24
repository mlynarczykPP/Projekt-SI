<?php

/**
 * Tag controller.
 */

namespace App\Controller;

use App\Entity\Tags;
use App\Form\TagsType;
use App\Repository\TagsRepository;
use App\Repository\TaskRepository;
use App\Service\TagService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TagController.
 *
 * @Route("/tags")
 */
class TagController extends AbstractController
{
    /**
     * Tag service.
     */
    private TagService $tagService;

    /**
     * TagController constructor.
     *
     * @param TagService $tagService Tag service
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP request
     * @param PaginatorInterface $paginator Paginator
     *
     * @param TagsRepository $tagsRepository Tags repository
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="tags_index",
     * )
     */
    public function index(Request $request, PaginatorInterface $paginator, TagsRepository $tagsRepository): Response
    {
        $pagination = $paginator->paginate(
            $tagsRepository->queryAll(),
            $request->query->getInt('page', 1),
            TagsRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('tags/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Tags $tags Tag entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="tags_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Tags $tags): Response
    {
        return $this->render('tags/show.html.twig', ['tags' => $tags]);
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
     *     name="tags_create",
     * )
     */
    public function create(Request $request): Response
    {
        $tags = new Tags();
        $form = $this->createForm(TagsType::class, $tags);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->save($tags);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('tags_index');
        }

        return $this->render('tags/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Tags    $tags    Tag entity
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
     *     name="tags_edit",
     * )
     */
    public function edit(Request $request, Tags $tags): Response
    {
        $form = $this->createForm(TagsType::class, $tags, ['method' => 'PUT']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->save($tags);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('tags_index');
        }

        return $this->render('tags/edit.html.twig', [
                'form' => $form->createView(),
                'tags' => $tags,
            ]);
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Tags    $tags    Tags entity
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
     *     name="tags_delete",
     * )
     */
    public function delete(Request $request, Tags $tags): Response
    {
        if ($tags->getNotes()->count()) {
            $this->addFlash('warning', 'message_tags_contains_note');

            return $this->redirectToRoute('tags_index');
        }

        if ($tags->getTasks()->count()) {
            $this->addFlash('warning', 'message_tags_contains_tasks');

            return $this->redirectToRoute('tags_index');
        }

        $form = $this->createForm(FormType::class, $tags, ['method' => 'DELETE']);
        $form->handleRequest($request);
        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->delete($tags);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('tags_index');
        }

        return $this->render('tags/delete.html.twig', [
                'form' => $form->createView(),
                'tags' => $tags,
            ]);
    }
}
