<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Groups("api")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * Assert\NotBlank(message = "Name may not be blank.")
     * Assert\Length(min = 0, max = 255, maxMessage = "Name cannot exceed {{ limit }} characters.")
     * @Groups("api")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="resumes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResumeSection", mappedBy="resume", orphanRemoval=true)
     * @Groups("api")
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
