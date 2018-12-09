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
 * @ORM\Entity(repositoryClass="App\Repository\ResumeSectionRepository")
 * @Gedmo\SoftDeleteable()
 */
class ResumeSection
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
     * Assert\NotBlank(message = "Title may not be blank.")
     * Assert\Length(min = 0, max = 255, maxMessage = "Title cannot exceed {{ limit }} characters.")
     * @Groups("api")
     */
    private $title;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private $position;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="App\Entity\Resume", inversedBy="resumeSections")
     * @ORM\JoinColumn(nullable=false)
     * Assert\NotBlank(message = "Resume is required.")
     */
    private $resume;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResumeSectionItem", mappedBy="resumeSection", orphanRemoval=true)
     * @Groups("api")
     */
    private $resumeSectionItems;

    public function __construct()
    {
        $this->resumeSectionItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(?Resume $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @return Collection|ResumeSectionItem[]
     */
    public function getResumeSectionItems(): Collection
    {
        return $this->resumeSectionItems;
    }

    public function addResumeSectionItem(ResumeSectionItem $resumeSectionItem): self
    {
        if (!$this->resumeSectionItems->contains($resumeSectionItem)) {
            $this->resumeSectionItems[] = $resumeSectionItem;
            $resumeSectionItem->setResumeSection($this);
        }

        return $this;
    }

    public function removeResumeSectionItem(ResumeSectionItem $resumeSectionItem): self
    {
        if ($this->resumeSectionItems->contains($resumeSectionItem)) {
            $this->resumeSectionItems->removeElement($resumeSectionItem);
            // set the owning side to null (unless already changed)
            if ($resumeSectionItem->getResumeSection() === $this) {
                $resumeSectionItem->setResumeSection(null);
            }
        }

        return $this;
    }
}
