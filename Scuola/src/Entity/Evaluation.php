<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'evaluation:item']),
        new GetCollection(normalizationContext: ['groups' => 'evaluation:list']),
        new Post(
            normalizationContext: ['groups' => 'evaluation:item'],
            denormalizationContext: ['groups' => 'evaluation:write']
        ),
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['evaluation:list', 'evaluation:item','evaluation:write'])]
    private ?Student $student = null;
    

    /**
     * @var Collection<int, EvaluationItem>
     */
    #[ORM\ManyToMany(targetEntity: EvaluationItem::class, inversedBy: 'evaluations')]
    #[Groups(['evaluation:list', 'evaluation:item','evaluation:write'])]
    private Collection $EvaluationItem;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['evaluation:list', 'evaluation:item','evaluation:write'])]
    private ?Activity $activity = null;

    public function __construct()
    {
        $this->EvaluationItem = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    /**
     * @return Collection<int, EvaluationItem>
     */
    public function getEvaluationItem(): Collection
    {
        return $this->EvaluationItem;
    }

    public function addEvaluationItem(EvaluationItem $evaluationItem): static
    {
        if (!$this->EvaluationItem->contains($evaluationItem)) {
            $this->EvaluationItem->add($evaluationItem);
        }

        return $this;
    }

    public function removeEvaluationItem(EvaluationItem $evaluationItem): static
    {
        $this->EvaluationItem->removeElement($evaluationItem);

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): static
    {
        $this->activity = $activity;

        return $this;
    }
}
