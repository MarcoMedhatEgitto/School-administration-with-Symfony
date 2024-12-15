<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ValutazioneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ValutazioneRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'evaluationModel:item']),
        new GetCollection(normalizationContext: ['groups' => 'evaluationModel:list']),
        new Post(
            normalizationContext: ['groups' => 'evaluationModel:item'],
            denormalizationContext: ['groups' => 'evaluationModel:write']
        ),
    ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class EvaluationModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['evaluationModel:list', 'evaluationModel:item','evaluationModel:write'])]
    private ?string $name = null;

    /**
     * @var Collection<int, EvaluationItem>
     */
    #[ORM\OneToMany(targetEntity: EvaluationItem::class, mappedBy: 'evaluationModel', orphanRemoval: true)]
    #[Groups(['evaluationModel:list', 'evaluationModel:item','evaluationModel:write'])]
    private Collection $evaluationItem;

    /**
     * @var Collection<int, Activity>
     */
    #[ORM\OneToMany(targetEntity: Activity::class, mappedBy: 'evaluationModel')]
    #[Groups(['evaluationModel:list', 'evaluationModel:item','evaluationModel:write'])]
    private Collection $activities;

    public function __construct()
    {
        $this->evaluationItem = new ArrayCollection();
        $this->activities = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getName();
    }
    public function getId(): ?string
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

    /**
     * @return Collection<int, EvaluationItem>
     */
    public function getEvaluationItem(): Collection
    {
        return $this->evaluationItem;
    }

    public function addEvaluationItem(EvaluationItem $evaluationItem): static
    {
        if (!$this->evaluationItem->contains($evaluationItem)) {
            $this->evaluationItem->add($evaluationItem);
            $evaluationItem->setEvaluationModel($this);
        }

        return $this;
    }

    public function removeEvaluationItem(EvaluationItem $evaluationItem): static
    {
        if ($this->evaluationItem->removeElement($evaluationItem)) {
            // set the owning side to null (unless already changed)
            if ($evaluationItem->getEvaluationModel() === $this) {
                $evaluationItem->setEvaluationModel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setEvaluationModel($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getEvaluationModel() === $this) {
                $activity->setEvaluationModel(null);
            }
        }

        return $this;
    }

}
