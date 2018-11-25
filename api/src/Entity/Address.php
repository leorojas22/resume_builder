<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 * @UniqueEntity(fields={"user"}, message="This user already has an address.")
 * @Gedmo\SoftDeleteable()
 */
class Address
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
     * @Assert\NotBlank(message = "Address line 1 may not be blank.")
     * @Assert\Length(min = 0, max = 255, maxMessage = "Address line 1 cannot exceed {{ limit }} characters.")
     * @Groups("api")
     */
    private $line1;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 0, max = 255, maxMessage = "Address line 2 cannot exceed {{ limit }} characters.")
     * @Groups("api")
     */
    private $line2 = "";

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "City may not be blank.")
     * @Assert\Length(min = 0, max = 255, maxMessage = "City cannot exceed {{ limit }} characters.")
     * @Groups("api")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=2)
     * @Assert\NotBlank(message = "State may not be blank.")
     * @Assert\Length(min = 2, max = 2, exactMessage = "State is required to be {{ limit }} characters.")
     * @Groups("api")
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message = "Postal code may not be blank.")
     * @Assert\Length(min = 5, max = 10, minMessage = "Postal code must be at least {{ limit }} characters.", maxMessage = "Postal code cannot exceed {{ limit }} characters.")
     * @Groups("api")
     */
    private $postal_code;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): self
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(string $line2): self
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
