<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\EvaluationStatus;

#[ORM\Entity(repositoryClass: "App\Repository\EvaluationRepository")]
#[ORM\Table(name: 'evaluations')]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Company::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $evaluationDate;

    #[ORM\Column(type: 'float')]
    private float $overallScore;

    #[ORM\Column(type: 'string', length: 50, enumType: EvaluationStatus::class)]
    private EvaluationStatus $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getEvaluationDate(): \DateTimeInterface
    {
        return $this->evaluationDate;
    }

    public function setEvaluationDate(\DateTimeInterface $evaluationDate): self
    {
        $this->evaluationDate = $evaluationDate;
        return $this;
    }

    public function getOverallScore(): float
    {
        return $this->overallScore;
    }

    public function setOverallScore(float $overallScore): self
    {
        $this->overallScore = $overallScore;
        return $this;
    }

    public function getStatus(): EvaluationStatus
    {
        return $this->status;
    }

    public function setStatus(EvaluationStatus $status): self
    {
        $this->status = $status;
        return $this;
    }
}
