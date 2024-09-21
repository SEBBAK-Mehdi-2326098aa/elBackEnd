<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserScoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserScoreRepository::class)]
#[ApiResource]
class UserScore
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, exercice>
     */
    #[ORM\ManyToMany(targetEntity: exercice::class)]
    private Collection $id_question;

    /**
     * @var Collection<int, user>
     */
    #[ORM\ManyToMany(targetEntity: user::class)]
    private Collection $id_user;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

    #[ORM\Column]
    private ?bool $exerciceCompleted = null;

    public function __construct()
    {
        $this->id_question = new ArrayCollection();
        $this->id_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, exercice>
     */
    public function getIdQuestion(): Collection
    {
        return $this->id_question;
    }

    public function addIdQuestion(exercice $idQuestion): static
    {
        if (!$this->id_question->contains($idQuestion)) {
            $this->id_question->add($idQuestion);
        }

        return $this;
    }

    public function removeIdQuestion(exercice $idQuestion): static
    {
        $this->id_question->removeElement($idQuestion);

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(user $idUser): static
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user->add($idUser);
        }

        return $this;
    }

    public function removeIdUser(user $idUser): static
    {
        $this->id_user->removeElement($idUser);

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function isExerciceCompleted(): ?bool
    {
        return $this->exerciceCompleted;
    }

    public function setExerciceCompleted(bool $exerciceCompleted): static
    {
        $this->exerciceCompleted = $exerciceCompleted;

        return $this;
    }
}
