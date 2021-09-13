<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryGroup::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryGroup;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Discussion::class, mappedBy="category", fetch="EAGER", orphanRemoval=true)
     */
    private $discussions;

    public function __construct()
    {
        $this->discussions = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        // Replace all non alphanumeric character or dash by a dash, then remove all dash at start or end
        // Finally, lower all character
        $this->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->name), '-'));
    }

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

    public function getCategoryGroup(): ?CategoryGroup
    {
        return $this->categoryGroup;
    }

    public function setCategoryGroup(?CategoryGroup $categoryGroup): self
    {
        $this->categoryGroup = $categoryGroup;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Discussion[]
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): self
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions[] = $discussion;
            $discussion->setCategory($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        if ($this->discussions->removeElement($discussion)) {
            // set the owning side to null (unless already changed)
            if ($discussion->getCategory() === $this) {
                $discussion->setCategory(null);
            }
        }

        return $this;
    }
}
