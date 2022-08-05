<?php

namespace App\Entity;

use App\Repository\OffersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
#[ORM\Entity(repositoryClass: OffersRepository::class)]
class Offers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public $id;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $title;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $type;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^\w+/")
     */
    #[ORM\Column(type: 'text')]
    private $description;


    /**
     * @Assert\Type("\DateTimeInterface")
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private $postedAt;



    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $website;


    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $requirements_item;


    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $requirements_content;


    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $role_item;


    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $role_content;

    #[ORM\OneToMany(mappedBy: 'offers', targetEntity: Candidates::class, cascade: ['remove'])]
    private $fk_candidat;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'offers', cascade: ['persist'])]
    private $fk_company;


    public function __toString():string{
        return $this->title;
    }

    public function __construct()
    {
        $this->fk_candidat = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPostedAt(): ?\DateTimeImmutable
    {
        return $this->postedAt;
    }

    public function setPostedAt(\DateTimeImmutable $postedAt): self
    {
        $this->postedAt = $postedAt;

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

    public function getRequirementsItem(): ?string
    {
        return $this->requirements_item;
    }

    public function setRequirementsItem(string $requirements_item): self
    {
        $this->requirements_item = $requirements_item;

        return $this;
    }

    public function getRequirementsContent(): ?string
    {
        return $this->requirements_content;
    }

    public function setRequirementsContent(string $requirements_content): self
    {
        $this->requirements_content = $requirements_content;

        return $this;
    }

    public function getRoleItem(): ?string
    {
        return $this->role_item;
    }

    public function setRoleItem(string $role_item): self
    {
        $this->role_item = $role_item;

        return $this;
    }

    public function getRoleContent(): ?string
    {
        return $this->role_content;
    }

    public function setRoleContent(string $role_content): self
    {
        $this->role_content = $role_content;

        return $this;
    }

    /**
     * @return Collection<int, Candidates>
     */
    public function getFkCandidat(): Collection
    {
        return $this->fk_candidat;
    }

    public function addFkCandidat(Candidates $fkCandidat): self
    {
        if (!$this->fk_candidat->contains($fkCandidat)) {
            $this->fk_candidat[] = $fkCandidat;
            $fkCandidat->setOffers($this);
        }

        return $this;
    }

    public function removeFkCandidat(Candidates $fkCandidat): self
    {
        if ($this->fk_candidat->removeElement($fkCandidat)) {
            // set the owning side to null (unless already changed)
            if ($fkCandidat->getOffers() === $this) {
                $fkCandidat->setOffers(null);
            }
        }

        return $this;
    }

    public function getFkCompany(): ?Company
    {
        return $this->fk_company;
    }

    public function setFkCompany(?Company $fk_company): self
    {
        $this->fk_company = $fk_company;

        return $this;
    }


}
