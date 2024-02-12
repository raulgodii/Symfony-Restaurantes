<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Entity\Restaurante;
use App\Form\LoginType;
use App\Form\RegistroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\FormError;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $restaurante = new Restaurante();
            $restauranteData = $form->getData();
            $correo = $restauranteData['correo'];
            $clave = $restauranteData['clave'];
            $restaurante->setCorreo($correo);
            $restaurante->setClave($clave);
            $user = $entityManager->getRepository(Restaurante::class)->findOneBy(['Correo' => $correo]);
            if ($user) {
                if ($user->getClave() == $restaurante->getClave()) {
                    $session->set('login', $user);
                    return $this->redirectToRoute('landing_page');
                }
            }
        }
    
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/registro', name: 'app_registro')]
    public function registro(Request $request, EntityManagerInterface $entityManager)
    {
        $restaurante = new Restaurante();
        $form = $this->createForm(RegistroType::class, $restaurante);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $restauranteData = $form->getData();
            $correo = $restauranteData->getCorreo();
            $existingRestaurante = $entityManager->getRepository(Restaurante::class)->findOneBy(['Correo' => $correo]);
    
            if ($existingRestaurante) {
                $form->addError(new FormError('Este correo ya está registrado.'));
            } else {
                $restaurante->setRol('restaurante');
    
                $entityManager->persist($restaurante);
                $entityManager->flush();
                return $this->redirectToRoute('landing_page');
            }
        }
        return $this->render('security/registro.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session)
    {
        $session->remove('login');
        return $this->redirectToRoute('landing_page');
    }
}
