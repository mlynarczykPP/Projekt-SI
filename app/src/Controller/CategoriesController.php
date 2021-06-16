<?php
/**
 * Categories controller.
 */

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoriesController.
 *
 * @Route("/categories")
 *
 * @IsGranted("ROLE_USER")
 */
class CategoriesController extends AbstractController
{
    private CategoriesRepository $categoriesRepository;

    private PaginatorInterface  $paginator;

    /**
     * CategoriesController constructor.
     *
     * @param CategoriesRepository      $categoriesRepository       Categories repository
     * @param PaginatorInterface        $paginator                  Paginator interface
     */
    public function __construct(CategoriesRepository $categoriesRepository, PaginatorInterface $paginator)
    {
        $this->categoriesRepository = $categoriesRepository;
        $this->paginator = $paginator;
    }

    /**
     * Index action.
     *
     * @param Request                   $request                    HTTP request
     * @param CategoriesRepository      $categoriesRepository       Categories repository
     * @param PaginatorInterface        $paginator                  Paginator
     *
     * @return Response                                             HTTP response
     *
     * @Route(
     *     "/",
     *     name="categories_index",
     * )
     */
    public function index(Request $request, CategoriesRepository $categoriesRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $categoriesRepository->queryAll(),
            $request->query->getInt('page', 1),
            CategoriesRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'categories/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Create action.
     *
     * @param Request               $request                HTTP request
     * @param CategoriesRepository  $categoriesRepository   Category repository
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="categories_create",
     *
     * )
     */
    public function create(Request $request, CategoriesRepository $categoriesRepository): Response
    {
        $categories = new Categories();
        $form = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->save($categories);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('categories_index');
        }

        return $this->render(
            'categories/create.html.twig',
            ['form' => $form->createView()]
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
     *     "/categories/{code}",
     *     methods={"GET"},
     *     name="categories_show",
     *     requirements={"code"},
     * )
     */
    public function show(Categories $categories): Response
    {
        return $this->render(
            'categories/show.html.twig',
            ['categories' => $categories]
        );
    }

    /**
     * Edit action.
     *
     * @param Request                   $request                HTTP request
     * @param Categories                $categories             Categories entity
     * @param CategoriesRepository      $categoriesRepository   Categories repository
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
     *     name="categories_edit",
     * )
     */
    public function edit(Request $request, Categories $categories, CategoriesRepository $categoriesRepository): Response
    {
        $form = $this->createForm(CategoriesType::class, $categories, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->save($categories);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('categories_index');
        }

        return $this->render(
            'categories/edit.html.twig',
            [
                'form' => $form->createView(),
                'categories' => $categories,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request     $request        HTTP request
     * @param \App\Entity\Categories                        $categories     Categories entity
     * @param \App\Repository\CategoriesRepository          $repositories   Categories repository
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
     *     name="categories_delete",
     * )
     */
    public function delete(Request $request, Categories $categories, CategoriesRepository $repository): Response
    {
        if ($categories->getTasks()->count()) {
            $this->addFlash('warning', 'message_categories_contains_tasks');

            return $this->redirectToRoute('categories_index');
        }

        $form = $this->createForm(FormType::class, $categories, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($categories);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('categories_index');
        }

        return $this->render(
            'categories/delete.html.twig',
            [
                'form' => $form->createView(),
                'categories' => $categories,
            ]
        );
    }
}