<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: LevelRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'level:item']),
        new GetCollection(normalizationContext: ['groups' => 'level:list']),
        new Post(
            normalizationContext: ['groups' => 'level:item'],
            denormalizationContext: ['groups' => 'level:write']
        ),
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['level:list', 'level:item','level:write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['level:list', 'level:item','level:write'])]
    private ?int $position = null;

    #[ORM\Column]
    #[Groups(['level:list', 'level:item','level:write'])]
    private ?int $value = null;

    /**
     * @var Collection<int, EvaluationItem>
     */
    #[ORM\OneToMany(targetEntity: EvaluationItem::class, mappedBy: 'level', orphanRemoval: true)]
    #[Groups(['level:list', 'level:item','level:write'])]
    private Collection $evaluationItems;

    public function __construct()
    {
        $this->evaluationItems = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, EvaluationItem>
     */
    public function getEvaluationItems(): Collection
    {
        return $this->evaluationItems;
    }

    public function addEvaluationItem(EvaluationItem $evaluationItem): static
    {
        if (!$this->evaluationItems->contains($evaluationItem)) {
            $this->evaluationItems->add($evaluationItem);
            $evaluationItem->setLevel($this);
        }

        return $this;
    }

    public function removeEvaluationItem(EvaluationItem $evaluationItem): static
    {
        if ($this->evaluationItems->removeElement($evaluationItem)) {
            // set the owning side to null (unless already changed)
            if ($evaluationItem->getLevel() === $this) {
                $evaluationItem->setLevel(null);
            }
        }

        return $this;
    }
}
