<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Psr\Log\LoggerInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    private $logger;

    public function __construct(UserPasswordHasherInterface $passwordHasher, LoggerInterface $logger)
    {
        $this->passwordHasher = $passwordHasher;
        $this->logger = $logger;
    }

    public function load(ObjectManager $manager): void
    {
        try {
            // Création d'un utilisateur par défaut
            $user = new User();
            $user->setName('Default User');
            $user->setEmail('defaultuser@example.com');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'defaultpassword'));
            $user->setRoles(['ROLE_USER']);

            // Assurez-vous d'assigner une entreprise si nécessaire
            // $user->setCompany($company);

            $manager->persist($user);
            $manager->flush();

            $this->logger->info('Utilisateur par défaut créé avec succès.');
        } catch (\Exception $e) {
            // Log l'erreur
            $this->logger->error('Erreur lors de la création de l\'utilisateur par défaut : ' . $e->getMessage());
            // Vous pouvez également rejeter l'exception si vous souhaitez interrompre le processus
            throw $e;
        }
    }
}
