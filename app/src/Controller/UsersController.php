<?php
/**
 * Users controller.
 */

namespace App\Controller;

use App\Entity\UserData;
use App\Form\UsersType;
use App\Repository\UserDataRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UsersController.
 *
 * @Route("/users")
 *
 */
class UsersController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request                   $request                HTTP request
     * @param UserDataRepository        $userdataRepository     Userdata repository
     * @param PaginatorInterface        $paginator              Paginator
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="users_index",
     * )
     */
    public function index(Request $request, UserDataRepository $userdataRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $userdataRepository->queryAll(),
            $request->query->getInt('page', 1),
            UserDataRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'users/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param UserData $userdata Userdata entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="users_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(UserData $userdata): Response
    {
        return $this->render(
            'users/show.html.twig',
            ['usersdata' => $userdata]
        );
    }

    /**
     * Create user.
     *
     * @param Request               $request            HTTP request
     * @param UserDataRepository    $userdataRepository Userdata repository
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="users_create",
     * )
     */
    public function create(Request $request, UserDataRepository $userdataRepository): Response
    {
        $userdata = new UserData();
        $form = $this->createForm(UsersType::class, $userdata);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userdataRepository->save($userdata);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('/index');
        }

        return $this->render(
            'users/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request               $request            HTTP request
     * @param UserData              $userdata           Userdata entity
     * @param UserDataRepository    $userdataRepository Userdata repository
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
     *     name="users_edit",
     * )
     */
    public function edit(Request $request, UserData $userdata, UserDataRepository $userdataRepository): Response
    {
        $form = $this->createForm(UsersType::class, $userdata, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userdataRepository->save($userdata);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('users/index.html.twig');
        }

        return $this->render(
            'users/edit.html.twig',
            [
                'form' => $form->createView(),
                'usersdata' => $userdata,
            ]
        );
    }
}