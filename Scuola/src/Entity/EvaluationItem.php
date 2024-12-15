<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\EvaluationItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EvaluationItemRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'evaluationItem:item']),
        new GetCollection(normalizationContext: ['groups' => 'evaluationItem:list']),
        new Post(
            normalizationContext: ['groups' => 'evaluationItem:Item'],
            denormalizationContext: ['groups' => 'evaluationItem:write']
        ),
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class EvaluationItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'evaluationItem')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['evaluationItem:list', 'evaluationItem:item','evaluationItem:write'])]
    private ?EvaluationModel $evaluationModel = null;

    #[ORM\ManyToOne(inversedBy: 'evaluationItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['evaluationItem:list', 'evaluationItem:item','evaluationItem:write'])]
    private ?Criteria $criteria = null;

    #[ORM\ManyToOne(inversedBy: 'evaluationItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['evaluationItem:list', 'evaluationItem:item','evaluationItem:write'])]
    private ?Level $level = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['evaluationItem:list', 'evaluationItem:item','evaluationItem:write'])]
    private ?string $description = null;

    /**
     * @var Collection<int, Evaluation>
     */
    #[ORM\ManyToMany(targetEntity: Evaluation::class, mappedBy: 'EvaluationItem')]
    #[Groups(['evaluationItem:list', 'evaluationItem:item','evaluationItem:write'])]
    private Collection $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->evaluationModel." ".$this->criteria . " " . $this->level;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvaluationModel(): ?EvaluationModel
    {
        return $this->evaluationModel;
    }

    public function setEvaluationModel(?EvaluationModel $evaluationModel): static
    {
        $this->evaluationModel = $evaluationModel;

        return $this;
    }

    public function getCriteria(): ?Criteria
    {
        return $this->criteria;
    }

    public function setCriteria(?Criteria $criteria): static
    {
        $this->criteria = $criteria;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->addEvaluationItem($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            $evaluation->removeEvaluationItem($this);
        }

        return $this;
    }
}
