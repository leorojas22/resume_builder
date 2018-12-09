<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 * @Gedmo\SoftDeleteable()
 */
class Phone
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
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="Phone may not be blank.")
     * @Assert\Length(min = 10, max = 10, exactMessage = "Phone is required to be {{ limit }} characters.")
     * @Groups("api")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Name may not be blank.")
     * @Assert\Length(min = 0, max = 255, maxMessage="Name cannot exceed {{ limit }} characters.")
     * @Groups("api")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="phones")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
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
}
