<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'products')]
    private Collection $commandes;

    #[ORM\OneToMany(mappedBy: 'Product', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToOne(mappedBy: 'discountprod', cascade: ['persist', 'remove'])]
    private ?DiscountProduct $discountProduct = null;

    #[ORM\ManyToMany(targetEntity: DiscountTotale::class, mappedBy: 'DiscountTProduct')]
    private Collection $discountTotales;


    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->discountTotales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOwner(): ?user
    {
        return $this->owner;
    }

    public function setOwner(?user $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addProduct($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }

    public function getDiscountProduct(): ?DiscountProduct
    {
        return $this->discountProduct;
    }

    public function setDiscountProduct(?DiscountProduct $discountProduct): self
    {
        // unset the owning side of the relation if necessary
        if ($discountProduct === null && $this->discountProduct !== null) {
            $this->discountProduct->setDiscountprod(null);
        }

        // set the owning side of the relation if necessary
        if ($discountProduct !== null && $discountProduct->getDiscountprod() !== $this) {
            $discountProduct->setDiscountprod($this);
        }

        $this->discountProduct = $discountProduct;

        return $this;
    }

    /**
     * @return Collection<int, DiscountTotale>
     */
    public function getDiscountTotales(): Collection
    {
        return $this->discountTotales;
    }

    public function addDiscountTotale(DiscountTotale $discountTotale): self
    {
        if (!$this->discountTotales->contains($discountTotale)) {
            $this->discountTotales->add($discountTotale);
            $discountTotale->addDiscountTProduct($this);
        }

        return $this;
    }

    public function removeDiscountTotale(DiscountTotale $discountTotale): self
    {
        if ($this->discountTotales->removeElement($discountTotale)) {
            $discountTotale->removeDiscountTProduct($this);
        }

        return $this;
    }

    
}
