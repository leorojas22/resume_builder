<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResumeSectionItemRepository")
 * @Gedmo\SoftDeleteable()
 */
class ResumeSectionItem
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
     * @ORM\Column(type="text")
     * Assert\NotBlank(message = "Content may not be blank.")
     * @Groups("api")
     */
    private $content;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     * Assert\NotBlank(message = "Position may not be blank.")
     * @Groups("api")
     */
    private $position;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="App\Entity\ResumeSection", inversedBy="resumeSectionItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $resumeSection;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getResumeSection(): ?ResumeSection
    {
        return $this->resumeSection;
    }

    public function setResumeSection(?ResumeSection $resumeSection): self
    {
        $this->resumeSection = $resumeSection;

        return $this;
    }
}
