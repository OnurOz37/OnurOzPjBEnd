<?php

namespace App\Entity;

use App\Repository\CandidatesRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_ADMIN')"],
    ],
    itemOperations: [
        "get",
        "put" => ["security" => "is_granted('ROLE_ADMIN') or object.owner == user"],
        "delete"
    ],
)]
#[ORM\Entity(repositoryClass: CandidatesRepository::class)]
class Candidates
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    /**
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le nom ne peut contenir de chiffre"
     * )
     */
    #[ORM\Column(type: 'string', length: 150)]
    private $firstname;


    /**
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+"
     * )
     */
    #[ORM\Column(type: 'string', length: 150)]
    private $lastname;



    #[ORM\Column(type: 'integer')]
    private $phone;


    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $email;


    /**
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $cv;

    #[ORM\ManyToOne(targetEntity: Offers::class, inversedBy: 'fk_candidat')]
    private $offers;


    public function __toString(): string
    {
        return $this->getEmail();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getOffers(): ?Offers
    {
        return $this->offers;
    }

    public function setOffers(?Offers $offers): self
    {
        $this->offers = $offers;

        return $this;
    }
}
