<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform;
use ApiPlatform\Core\Api;
use ApiPlatform\Core\Annotation\ApiResource;

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
    input: Company::class
)]
#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $name;


    /**
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 400,
     *     minHeight = 200,
     *     maxHeight = 400
     * )
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $logo;


    /**
     * @Assert\CssColor
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $logoColor;


    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 150)]
    private $city;


    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $website;


    /**
     * @Assert\Positive
     */
    #[ORM\Column(type: 'integer')]
    private $phone;


    #[ORM\OneToMany(mappedBy: 'fk_company', targetEntity: Offers::class, cascade: ['persist'])]
    private $offers;

    #[ORM\OneToOne(inversedBy: 'company', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $fk_user;


    public function __toString(): string
    {
        return $this->getName();
    }


    public function __construct()
    {

        $this->offers = new ArrayCollection();








    }

//    public function __toString(): string
//    {
//        return $this->getId();
//    }

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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLogoColor(): ?string
    {
        return $this->logoColor;
    }

    public function setLogoColor(string $logoColor): self
    {
        $this->logoColor = $logoColor;

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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

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



    /**
     * @return Collection<int, Offers>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offers $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setFkCompany($this);
        }

        return $this;
    }

    public function removeOffer(Offers $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getFkCompany() === $this) {
                $offer->setFkCompany(null);
            }
        }

        return $this;
    }

    public function getFkUser(): ?User
    {
        return $this->fk_user;
    }

    public function setFkUser(?User $fk_user): self
    {
        $this->fk_user = $fk_user;

        return $this;
    }

    




    















}
