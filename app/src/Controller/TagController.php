<?php
/**
 * Tag controller.
 */

namespace App\Controller;

use App\Entity\Tags;
use App\Form\TagsType;
use App\Repository\TagsRepository;
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
    private TagsRepository $tagsRepository;

    private PaginatorInterface  $paginator;

    /**
     * TagController constructor.
     *
     * @param TagsRepository            $tagsRepository           Tags repository
     * @param PaginatorInterface        $paginator                Paginator interface
     */
    public function __construct(TagsRepository $tagsRepository, PaginatorInterface $paginator)
    {
        $this->tagsRepository = $tagsRepository;
        $this->paginator = $paginator;
    }

    /**
     * Index action.
     *
     * @param Request                   $request                    HTTP request
     * @param TagsRepository            $tagsRepository             Tags repository
     * @param PaginatorInterface        $paginator                  Paginator
     *
     * @return Response                                             HTTP response
     *
     * @Route(
     *     "/",
     *     name="tags_index",
     * )
     */
    public function index(Request $request, TagsRepository $tagsRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $tagsRepository->queryAll(),
            $request->query->getInt('page', 1),
            TagsRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'tags/index.html.twig',
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
     *     "/tags/{code}",
     *     methods={"GET"},
     *     name="tags_show",
     *     requirements={"code"},
     * )
     */
    public function show(Tags $tags): Response
    {
        return $this->render(
            'tags/show.html.twig',
            ['tags' => $tags]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request                  HTTP request
     * @param TagsRepository $tagsRepository    Tags repository
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="tags_create",
     * )
     */
    public function create(Request $request, TagsRepository $tagsRepository): Response
    {
        $tags = new Tags();
        $form = $this->createForm(TagsType::class, $tags);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagsRepository->save($tags);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('tags_index');
        }

        return $this->render(
            'tags/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request           $request                HTTP request
     * @param Tags              $tags                   Tags entity
     * @param TagsRepository    $tagsRepository         Tags repository
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{code}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"code"},
     *     name="tags_edit",
     * )
     */
    public function edit(Request $request, Tags $tags, TagsRepository $tagsRepository): Response
    {
        $form = $this->createForm(TagsType::class, $tags, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagsRepository->save($tags);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('tags_index');
        }

        return $this->render(
            'tags/edit.html.twig',
            [
                'form' => $form->createView(),
                'tags' => $tags,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Tags                          $tags       Tags entity
     * @param \App\Repository\TagsRepository            $repository Category repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{code}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"code"},
     *     name="tags_delete",
     * )
     */
    public function delete(Request $request, Tags $tags, TagsRepository $repository): Response
    {
        if ($tags->getNotes()->count()) {
            $this->addFlash('warning', 'message_tags_contains_notes');

            return $this->redirectToRoute('tags_index');
        }

        $form = $this->createForm(FormType::class, $tags, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($tags);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('tags_index');
        }

        return $this->render(
            'tags/delete.html.twig',
            [
                'form' => $form->createView(),
                'tags' => $tags,
            ]
        );
    }
}