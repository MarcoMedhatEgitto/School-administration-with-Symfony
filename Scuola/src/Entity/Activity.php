<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'activity:item']),
        new GetCollection(normalizationContext: ['groups' => 'activity:list']),
        new Post(
            normalizationContext: ['groups' => 'activity:item'],
            denormalizationContext: ['groups' => 'activity:write']
        ),
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['activity:list', 'activity:item','activity:write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['activity:list', 'activity:item','activity:write'])]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['activity:list', 'activity:item','activity:write'])]
    private ?EvaluationModel $evaluationModel = null;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['activity:list', 'activity:item','activity:write'])]
    private ?Classroom $classroom = null;

    /**
     * @var Collection<int, Evaluation>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'activity', orphanRemoval: true)]
    #[Groups(['activity:list', 'activity:item','activity:write'])]
    private Collection $evaluations;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
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

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
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

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): static
    {
        $this->classroom = $classroom;

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
            $evaluation->setActivity($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getActivity() === $this) {
                $evaluation->setActivity(null);
            }
        }

        return $this;
    }
}
