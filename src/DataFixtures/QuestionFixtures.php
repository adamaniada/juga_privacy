<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\QuestionCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

class QuestionFixtures extends Fixture
{
    private $logger;
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        $questionsData = [
            // Section 1: Collecte et Utilisation des Données
            [
                'text' => 'Quelles données personnelles collectez-vous auprès de vos clients/utilisateurs ? Nom',
                'category' => QuestionCategory::GestionDesDonnees,
                'weight' => 3,
            ],
            [
                'text' => 'Quelles données personnelles collectez-vous auprès de vos clients/utilisateurs ? Adresse e-mail',
                'category' => QuestionCategory::GestionDesDonnees,
                'weight' => 3,
            ],
            [
                'text' => 'Quelles données personnelles collectez-vous auprès de vos clients/utilisateurs ? Numéro de téléphone',
                'category' => QuestionCategory::GestionDesDonnees,
                'weight' => 3,
            ],
            [
                'text' => 'Quelles données personnelles collectez-vous auprès de vos clients/utilisateurs ? Autres (précisez)',
                'category' => QuestionCategory::GestionDesDonnees,
                'weight' => 3,
            ],
            [
                'text' => 'Avez-vous obtenu le consentement explicite des utilisateurs pour collecter et utiliser leurs données personnelles ?',
                'category' => QuestionCategory::Consentement,
                'weight' => 8,
            ],
            [
                'text' => 'Les utilisateurs peuvent-ils facilement retirer leur consentement à tout moment ?',
                'category' => QuestionCategory::Consentement,
                'weight' => 7,
            ],
            [
                'text' => 'Utilisez-vous les données personnelles uniquement pour les finalités pour lesquelles elles ont été collectées ?',
                'category' => QuestionCategory::GestionDesDonnees,
                'weight' => 9,
            ],
            [
                'text' => 'Informez-vous les utilisateurs des changements dans l\'utilisation de leurs données personnelles ?',
                'category' => QuestionCategory::Transparence,
                'weight' => 6,
            ],

            // Section 2: Transparence et Information
            [
                'text' => 'Avez-vous une politique de confidentialité claire et accessible sur votre site web ?',
                'category' => QuestionCategory::Transparence,
                'weight' => 9,
            ],
            [
                'text' => 'Informez-vous les utilisateurs de la manière dont leurs données seront utilisées, stockées et partagées ?',
                'category' => QuestionCategory::Transparence,
                'weight' => 8,
            ],
            [
                'text' => 'Fournissez-vous des informations sur les droits des utilisateurs concernant leurs données personnelles (accès, rectification, suppression) ?',
                'category' => QuestionCategory::DroitsDesUtilisateurs,
                'weight' => 8,
            ],
            [
                'text' => 'Votre politique de confidentialité est-elle rédigée dans un langage clair et compréhensible ?',
                'category' => QuestionCategory::Transparence,
                'weight' => 7,
            ],

            // Section 3: Sécurité des Données
            [
                'text' => 'Quelles mesures de sécurité avez-vous mises en place pour protéger les données personnelles ? Chiffrement',
                'category' => QuestionCategory::SecuriteDesDonnees,
                'weight' => 9,
            ],
            [
                'text' => 'Quelles mesures de sécurité avez-vous mises en place pour protéger les données personnelles ? Contrôles d\'accès',
                'category' => QuestionCategory::SecuriteDesDonnees,
                'weight' => 9,
            ],
            [
                'text' => 'Quelles mesures de sécurité avez-vous mises en place pour protéger les données personnelles ? Sauvegardes',
                'category' => QuestionCategory::SecuriteDesDonnees,
                'weight' => 8,
            ],
            [
                'text' => 'Quelles mesures de sécurité avez-vous mises en place pour protéger les données personnelles ? Autres (précisez)',
                'category' => QuestionCategory::SecuriteDesDonnees,
                'weight' => 7,
            ],
            [
                'text' => 'Avez-vous un plan de réponse aux incidents de sécurité en place ?',
                'category' => QuestionCategory::SecuriteDesDonnees,
                'weight' => 9,
            ],
            [
                'text' => 'Effectuez-vous des audits réguliers de sécurité pour identifier et corriger les vulnérabilités ?',
                'category' => QuestionCategory::ConformiteEtAudit,
                'weight' => 8,
            ],
            [
                'text' => 'Les employés sont-ils formés aux bonnes pratiques de sécurité des données ?',
                'category' => QuestionCategory::FormationEtSensibilisation,
                'weight' => 7,
            ],

            // Section 4: Gestion des Données
            [
                'text' => 'Conservez-vous les données personnelles uniquement pendant la durée nécessaire à la réalisation des finalités pour lesquelles elles sont traitées ?',
                'category' => QuestionCategory::GestionDesDonnees,
                'weight' => 9,
            ],
            [
                'text' => 'Avez-vous un processus pour supprimer les données personnelles lorsqu\'elles ne sont plus nécessaires ?',
                'category' => QuestionCategory::GestionDesDonnees,
                'weight' => 8,
            ],
            [
                'text' => 'Les utilisateurs peuvent-ils demander la suppression de leurs données personnelles ?',
                'category' => QuestionCategory::DroitsDesUtilisateurs,
                'weight' => 8,
            ],
            [
                'text' => 'Avez-vous une procédure pour anonymiser les données lorsque cela est possible ?',
                'category' => QuestionCategory::GestionDesDonnees,
                'weight' => 6,
            ],

            // Section 5: Partage et Transfert des Données
            [
                'text' => 'Partagez-vous des données personnelles avec des tiers ? Si oui, avec qui et à quelles fins ?',
                'category' => QuestionCategory::PartageEtTransfertDesDonnees,
                'weight' => 7,
            ],
            [
                'text' => 'Avez-vous des accords de traitement des données avec vos sous-traitants ?',
                'category' => QuestionCategory::PartageEtTransfertDesDonnees,
                'weight' => 8,
            ],
            [
                'text' => 'Transférez-vous des données personnelles en dehors de l\'UE/EEE ? Si oui, quelles mesures de protection avez-vous mises en place ?',
                'category' => QuestionCategory::PartageEtTransfertDesDonnees,
                'weight' => 7,
            ],

            // Section 6: Droits des Utilisateurs
            [
                'text' => 'Les utilisateurs peuvent-ils facilement accéder à leurs données personnelles que vous détenez ?',
                'category' => QuestionCategory::DroitsDesUtilisateurs,
                'weight' => 9,
            ],
            [
                'text' => 'Permettez-vous aux utilisateurs de corriger ou de mettre à jour leurs données personnelles ?',
                'category' => QuestionCategory::DroitsDesUtilisateurs,
                'weight' => 8,
            ],
            [
                'text' => 'Avez-vous un processus pour répondre aux demandes des utilisateurs concernant leurs droits en matière de protection des données ?',
                'category' => QuestionCategory::DroitsDesUtilisateurs,
                'weight' => 8,
            ],
            [
                'text' => 'Informez-vous les utilisateurs de leurs droits en matière de protection des données ?',
                'category' => QuestionCategory::DroitsDesUtilisateurs,
                'weight' => 7,
            ],

            // Section 7: Formation et Sensibilisation
            [
                'text' => 'Avez-vous formé vos employés sur les bonnes pratiques en matière de protection des données ?',
                'category' => QuestionCategory::FormationEtSensibilisation,
                'weight' => 8,
            ],
            [
                'text' => 'Organisez-vous des sessions de sensibilisation régulières sur la protection des données pour vos employés ?',
                'category' => QuestionCategory::FormationEtSensibilisation,
                'weight' => 7,
            ],
            [
                'text' => 'Les employés sont-ils informés des dernières exigences légales en matière de protection des données ?',
                'category' => QuestionCategory::FormationEtSensibilisation,
                'weight' => 7,
            ],

            // Section 8: Conformité et Audit
            [
                'text' => 'Avez-vous désigné un Délégué à la Protection des Données (DPO) ?',
                'category' => QuestionCategory::DelegueALaProtectionDesDonneesDPO,
                'weight' => 8,
            ],
            [
                'text' => 'Effectuez-vous des audits internes réguliers pour vérifier la conformité aux réglementations sur la protection des données ?',
                'category' => QuestionCategory::ConformiteEtAudit,
                'weight' => 8,
            ],
            [
                'text' => 'Avez-vous mis en place des procédures pour signaler les violations de données aux autorités compétentes et aux personnes concernées ?',
                'category' => QuestionCategory::ConformiteEtAudit,
                'weight' => 9,
            ],
            [
                'text' => 'Documentez-vous toutes les activités de traitement des données personnelles ?',
                'category' => QuestionCategory::DocumentationEtPreuves,
                'weight' => 7,
            ],
        ];

        foreach ($questionsData as $data) {
            $existingQuestion = $this->entityManager->getRepository(Question::class)->findOneBy(['text' => $data['text']]);

            if (!$existingQuestion) {
                try {
                    $question = new Question();
                    $question->setText($data['text']);
                    $question->setCategory($data['category']);
                    $question->setWeight($data['weight']);
                    $manager->persist($question);
                } catch (\Exception $e) {
                    $this->logger->error('Erreur lors de la création de la question "' . $data['text'] . '" : ' . $e->getMessage());
                    throw $e;
                }
            } else {
                $this->logger->info('La question "' . $data['text'] . '" existe déjà. Aucune création nécessaire.');
            }
        }

        $manager->flush();
        $this->logger->info('Questions de l\'audit de protection des données créées ou vérifiées avec succès.');
    }
}