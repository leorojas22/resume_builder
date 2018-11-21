<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResumeRepository")
 * @Gedmo\SoftDeleteable()
 */
class Resume
{

    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resumes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResumeSection", mappedBy="resume", orphanRemoval=true)
     */
    private $resumeSections;

    public function __construct()
    {
        $this->resumeSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|ResumeSection[]
     */
    public function getResumeSections(): Collection
    {
        return $this->resumeSections;
    }

    public function addResumeSection(ResumeSection $resumeSection): self
    {
        if (!$this->resumeSections->contains($resumeSection)) {
            $this->resumeSections[] = $resumeSection;
            $resumeSection->setResume($this);
        }

        return $this;
    }

    public function removeResumeSection(ResumeSection $resumeSection): self
    {
        if ($this->resumeSections->contains($resumeSection)) {
            $this->resumeSections->removeElement($resumeSection);
            // set the owning side to null (unless already changed)
            if ($resumeSection->getResume() === $this) {
                $resumeSection->setResume(null);
            }
        }

        return $this;
    }
}
