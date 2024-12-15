<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
#[ApiResource(
        operations: [
            new Get(normalizationContext: ['groups' => 'classroom:item']),
            new GetCollection(normalizationContext: ['groups' => 'classroom:list']),
            new Post(
                normalizationContext: ['groups' => 'classroom:item'],
                denormalizationContext: ['groups' => 'classroom:write']
            ),
        ],
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class Classroom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['classroom:list', 'classroom:item'])]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    #[Groups(['classroom:list', 'classroom:item','classroom:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['classroom:list', 'classroom:item','classroom:write'])]
    private ?string $schoolYear = null;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'classroom', orphanRemoval: true,cascade: ['persist'])]
    #[Groups(['classroom:list', 'classroom:item'])]
    private Collection $students;

    /**
     * @var Collection<int, Activity>
     */
    #[ORM\OneToMany(targetEntity: Activity::class, mappedBy: 'classroom', orphanRemoval: true, cascade: ['persist'])]
    #[Groups(['classroom:list', 'classroom:item'])]
    private Collection $activities;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->activities = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->name.' '.$this->schoolYear;
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

    public function getSchoolYear(): ?string
    {
        return $this->schoolYear;
    }

    public function setSchoolYear(string $schoolYear): static
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setClassroom($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getClassroom() === $this) {
                $student->setClassroom(null);
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
            $activity->setClassroom($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getClassroom() === $this) {
                $activity->setClassroom(null);
            }
        }

        return $this;
    }

}
