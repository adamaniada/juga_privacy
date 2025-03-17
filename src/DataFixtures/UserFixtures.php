<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;
    private $logger;
    private $entityManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        LoggerInterface $logger,
        EntityManagerInterface $entityManager
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        $defaultEmail = 'defaultuser@example.com';

        // Vérifier si l'utilisateur avec cet email existe déjà
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $defaultEmail]);

        if (!$existingUser) {
            try {
                // Création d'un utilisateur par défaut
                $user = new User();
                $user->setName('Default User');
                $user->setEmail($defaultEmail);
                $user->setPassword($this->passwordHasher->hashPassword($user, 'defaultpassword'));
                $user->setRoles(['ROLE_USER']);
                $manager->persist($user);
                $manager->flush();
                $this->logger->info('Utilisateur par défaut créé avec succès.');
            } catch (\Exception $e) {
                $this->logger->error('Erreur lors de la création de l\'utilisateur par défaut : ' . $e->getMessage());
                throw $e;
            }
        } else {
            $this->logger->info('L\'utilisateur avec l\'email "' . $defaultEmail . '" existe déjà. Aucune création nécessaire.');
        }
    }
}