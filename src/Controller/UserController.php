<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;
use App\Form\UserType;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $manager = $this -> getDoctrine() -> getManager();
        $user = new User;
        $form = $this -> createForm(UserType::class, $user);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {
            $manager -> persist($user);
            $password = $user -> getPassword();
            $user -> setPassword($encoder -> encodePassword($user, $password));
            $user -> uploadFile();

            $manager -> flush();
            $this -> addFlash('success', 'Votre inscription a été prise en compte');
            return $this -> redirectToRoute('login');
        }

        return $this->render('test/register_form.html.twig', array(
            'userForm' => $form -> createView()
        ));
    }

    /**
     * @Route("/", name="login")
     */
    public function login(AuthenticationUtils $auth)
    {
        $lastUsername = $auth -> getLastUsername();
        $error = $auth -> getLastAuthenticationError();
        if($error) {
            $this -> addFlash('errors', 'Problème d\'identification');
        }
        return $this->render('test/login_form.html.twig', array(
            'lastUsername' => $lastUsername,
        ));
    }
    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheck() {

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('login');
    }
}
