<?php

namespace App\Entity;

use App\Repository\DiscountTotaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscountTotaleRepository::class)]
class DiscountTotale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codePromo = null;

    #[ORM\Column(nullable: true)]
    private ?float $ValeurPromo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToMany(mappedBy: 'discountTotale', targetEntity: Commande::class)]
    private Collection $discountTCommande;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'discountTotales')]
    private Collection $DiscountTProduct;

    public function __construct()
    {
        $this->discountTCommande = new ArrayCollection();
        $this->DiscountTProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePromo(): ?string
    {
        return $this->codePromo;
    }

    public function setCodePromo(?string $codePromo): self
    {
        $this->codePromo = $codePromo;

        return $this;
    }

    public function getValeurPromo(): ?float
    {
        return $this->ValeurPromo;
    }

    public function setValeurPromo(?float $ValeurPromo): self
    {
        $this->ValeurPromo = $ValeurPromo;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getDiscountTCommande(): Collection
    {
        return $this->discountTCommande;
    }

    public function addDiscountTCommande(Commande $discountTCommande): self
    {
        if (!$this->discountTCommande->contains($discountTCommande)) {
            $this->discountTCommande->add($discountTCommande);
            $discountTCommande->setDiscountTotale($this);
        }

        return $this;
    }

    public function removeDiscountTCommande(Commande $discountTCommande): self
    {
        if ($this->discountTCommande->removeElement($discountTCommande)) {
            // set the owning side to null (unless already changed)
            if ($discountTCommande->getDiscountTotale() === $this) {
                $discountTCommande->setDiscountTotale(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getDiscountTProduct(): Collection
    {
        return $this->DiscountTProduct;
    }

    public function addDiscountTProduct(Product $discountTProduct): self
    {
        if (!$this->DiscountTProduct->contains($discountTProduct)) {
            $this->DiscountTProduct->add($discountTProduct);
        }

        return $this;
    }

    public function removeDiscountTProduct(Product $discountTProduct): self
    {
        $this->DiscountTProduct->removeElement($discountTProduct);

        return $this;
    }
}
