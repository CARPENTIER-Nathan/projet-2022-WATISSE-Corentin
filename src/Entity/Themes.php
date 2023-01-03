<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemesRepository::class)]
class Themes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\OneToMany(targetEntity: 'Discussions', mappedBy: 'Theme', fetch:"EXTRA_LAZY", cascade:['persist', 'remove'] )]
    public $Discussions;

    public function __construct()
    {
        $this->Discussions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection<int, Discussions>
     */
    public function getDiscussions(): Collection
    {
        return $this->Discussions;
    }

    public function addDiscussion(Discussions $discussion): self
    {
        if (!$this->Discussions->contains($discussion)) {
            $this->Discussions->add($discussion);
            $discussion->setTheme($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussions $discussion): self
    {
        if ($this->Discussions->removeElement($discussion)) {
            // set the owning side to null (unless already changed)
            if ($discussion->getTheme() === $this) {
                $discussion->setTheme(null);
            }
        }

        return $this;
    }



}
