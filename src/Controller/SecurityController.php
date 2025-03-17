<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class SecurityController extends AbstractController
{
    private TokenStorageInterface $tokenStorage;
    private UserPasswordHasherInterface $passwordHasher;
    private LoggerInterface $logger;

    public function __construct(TokenStorageInterface $tokenStorage, UserPasswordHasherInterface $passwordHasher, LoggerInterface $logger)
    {
        $this->tokenStorage = $tokenStorage;
        $this->passwordHasher = $passwordHasher;
        $this->logger = $logger;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processRegistration($form, $entityManager, $user);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    private function processRegistration($form, EntityManagerInterface $entityManager, User $user): Response
    {
        $company = $this->createCompanyFromForm($form);
        $entityManager->persist($company);
        $entityManager->flush();

        $user->setCompany($company);
        $plainPassword = $form->get('plainPassword')->getData();

        if ($plainPassword) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        } else {
            $this->logger->error('Le mot de passe n\'a pas été fourni lors de l\'inscription.');
            $this->addFlash('danger', 'Une erreur est survenue lors de la création du compte.');
            return $this->redirectToRoute('app_register');
        }

        $entityManager->persist($user);

        try {
            $entityManager->flush();
            $this->addFlash('success', 'Votre compte a été créé avec succès. Veuillez vous connecter.');
            return $this->redirectToRoute('app_login');
        } catch (UniqueConstraintViolationException $e) {
            return $this->handleUniqueConstraintViolation($e, $form);
        }
    }

    private function createCompanyFromForm($form): Company
    {
        $company = new Company();
        $company->setName($form->get('companyName')->getData());
        $company->setAddress($form->get('companyAddress')->getData());
        $company->setContact($form->get('companyContact')->getData());
        $company->setSector($form->get('companySector')->getData());

        return $company;
    }

    private function handleUniqueConstraintViolation(UniqueConstraintViolationException $e, $form): Response
    {
        if (strpos($e->getMessage(), 'users.UNIQ_1483A5E9E7927C74') !== false) {
            $this->addFlash('danger', 'Cet email est déjà utilisé. Veuillez en choisir un autre.');
        } else {
            $this->logger->error('Erreur de base de données lors de l\'inscription : ' . $e->getMessage());
            $this->addFlash('danger', 'Une erreur est survenue lors de la création du compte.');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error) {
            $this->logger->error('Login error: ' . $error->getMessage());
            $this->addFlash('danger', 'Identifiants incorrects');
        }

        $this->logger->info('Last username: ' . $lastUsername);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('Cette méthode est interceptée par le firewall de Symfony.');
    }

    #[Route('/profil', name: 'app_profile')]
    public function profile(): Response
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        if (!$user || !is_object($user)) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir cette page.');
        }

        return $this->render('security/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/admin', name: 'app_admin')]
    public function adminDashboard(): Response
    {
        $user = $this->tokenStorage->getToken()?->getUser();

        if (!$user || !is_object($user) || !in_array('ROLE_ADMIN', $user->getRoles())) {
            throw $this->createAccessDeniedException('Accès réservé aux administrateurs.');
        }

        return $this->render('admin/dashboard.html.twig', [
            'user' => $user,
        ]);
    }
}
