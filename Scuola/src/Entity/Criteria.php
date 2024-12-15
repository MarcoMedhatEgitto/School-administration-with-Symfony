<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\CriteriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CriteriaRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'criteria:item']),
        new GetCollection(normalizationContext: ['groups' => 'criteria:list']),
        new Post(
            normalizationContext: ['groups' => 'criteria:item'],
            denormalizationContext: ['groups' => 'criteria:write']
        ),
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class Criteria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['criteria:list', 'criteria:item','criteria:write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['criteria:list', 'criteria:item','criteria:write'])]
    private ?int $position = null;

    /**
     * @var Collection<int, EvaluationItem>
     */
    #[ORM\OneToMany(targetEntity: EvaluationItem::class, mappedBy: 'criteria', orphanRemoval: true)]
    #[Groups(['criteria:list', 'criteria:item','criteria:write'])]
    private Collection $evaluationItems;

    public function __construct()
    {
        $this->evaluationItems = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
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
            $evaluationItem->setCriteria($this);
        }

        return $this;
    }

    public function removeEvaluationItem(EvaluationItem $evaluationItem): static
    {
        if ($this->evaluationItems->removeElement($evaluationItem)) {
            // set the owning side to null (unless already changed)
            if ($evaluationItem->getCriteria() === $this) {
                $evaluationItem->setCriteria(null);
            }
        }

        return $this;
    }
}
