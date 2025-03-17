<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

enum QuestionCategory: string
{
    case Transparence = 'Transparence';
    case Consentement = 'Consentement';
    case SecuriteDesDonnees = 'Sécurité des Données';
    case GestionDesDonnees = 'Gestion des Données';
    case DroitsDesUtilisateurs = 'Droits des Utilisateurs';
    case PartageEtTransfertDesDonnees = 'Partage et Transfert des Données';
    case FormationEtSensibilisation = 'Formation et Sensibilisation';
    case ConformiteEtAudit = 'Conformité et Audit';
    case DelegueALaProtectionDesDonneesDPO = 'Délégué à la Protection des Données (DPO)';
    case DocumentationEtPreuves = 'Documentation et Preuves';
    case GestionDesRisques = 'Gestion des Risques';
    case ResponsabiliteEtGouvernance = 'Responsabilité et Gouvernance';
}

#[ORM\Entity(repositoryClass: "App\Repository\QuestionRepository")]
#[ORM\Table(name: 'questions')]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private string $text;

    #[ORM\Column(type: 'string', enumType: QuestionCategory::class)]
    private QuestionCategory $category;

    #[ORM\Column(type: 'integer')]
    private int $weight;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getCategory(): QuestionCategory
    {
        return $this->category;
    }

    public function setCategory(QuestionCategory $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;
        return $this;
    }
}
