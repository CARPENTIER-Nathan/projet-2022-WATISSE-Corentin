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

    #[ORM\ManyToOne(targetEntity: 'Themes', inversedBy: 'Discussions')]
    #[ORM\JoinColumn(name:"themes_id", referencedColumnName:"id", nullable:false)]
    public $Theme = null;

    #[ORM\ManyToOne(targetEntity: 'User', inversedBy: 'Discussions')]
    #[ORM\JoinColumn(name:"user_id", referencedColumnName:"id", nullable:false)]
    public $Use = null;


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

    public function getTheme(): ?Themes
    {
        return $this->Theme;
    }

    public function setTheme(?Themes $Theme): self
    {
        $this->Theme = $Theme;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }


}
