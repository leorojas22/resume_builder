<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="App\Entity\Resume", inversedBy="resumeSections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $resume;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResumeSectionItem", mappedBy="resumeSection", orphanRemoval=true)
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

    public function getProperty(): ?int
    {
        return $this->property;
    }

    public function setProperty(int $property): self
    {
        $this->property = $property;

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
