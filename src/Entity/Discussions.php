<?php

namespace App\Entity;

use App\Repository\DiscussionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscussionsRepository::class)]
class Discussions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 999)]
    private ?string $Contenu = null;

    #[ORM\Column(length: 20)]
    private ?string $DateCreation = null;

    #[ORM\Column(length: 20)]
    private ?string $DateModification = null;

    #[ORM\Column(length: 255)]
    private ?string $Createur = null;

    #[ORM\ManyToOne(targetEntity: Themes::class, inversedBy: 'nom')]
    private ?string $Theme = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getDateCreation(): ?string
    {
        return $this->DateCreation;
    }

    public function setDateCreation(string $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getDateModification(): ?string
    {
        return $this->DateModification;
    }

    public function setDateModification(string $DateModification): self
    {
        $this->DateModification = $DateModification;

        return $this;
    }

    public function getCreateur(): ?string
    {
        return $this->Createur;
    }

    public function setCreateur(string $Createur): self
    {
        $this->Createur = $Createur;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->Theme;
    }

    public function setTheme(string $Theme): self
    {
        $this->Theme = $Theme;

        return $this;
    }
}
