<?php

/**
 * Registration Controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController.
 */
class RegistrationController extends AbstractController
{
    /**
     * Registration.
     *
     * @param Request                      $request         HTTP request
     * @param UserPasswordEncoderInterface $passwordEncoder Password encoder
     *
     * @return RedirectResponse|Response HTTP return
     *
     * @Route(
     *     "/register",
     *     methods={"GET", "POST"},
     *     name="registration_register"
     * )
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles([User::ROLE_USER]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('index');
        }

        return $this->render('registration/register.html.twig', ['form' => $form->createView()]);
    }
}
