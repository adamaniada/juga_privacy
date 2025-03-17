<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\AuditRepository")]
#[ORM\Table(name: 'audits')]
class Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Company::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $auditDate;

    #[ORM\Column(type: 'text')]
    private string $results;

    #[ORM\Column(type: 'text')]
    private string $correctiveActions;

    public function getid(): ?int
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

    public function getAuditDate(): \DateTimeInterface
    {
        return $this->auditDate;
    }

    public function setAuditDate(\DateTimeInterface $auditDate): self
    {
        $this->auditDate = $auditDate;
        return $this;
    }

    public function getResults(): string
    {
        return $this->results;
    }

    public function setResults(string $results): self
    {
        $this->results = $results;
        return $this;
    }

    public function getCorrectiveActions(): string
    {
        return $this->correctiveActions;
    }

    public function setCorrectiveActions(string $correctiveActions): self
    {
        $this->correctiveActions = $correctiveActions;
        return $this;
    }
}
