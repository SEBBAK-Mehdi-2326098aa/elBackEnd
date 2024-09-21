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
    #[ORM\ManyToOne(targetEntity: exercice::class)]
    private Collection $question;

    /**
     * @var Collection<int, user>
     */
    #[ORM\ManyToOne(targetEntity: user::class)]
    private Collection $user;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

    #[ORM\Column]
    private ?bool $exerciceCompleted = false;

    public function __construct()
    {
        $this->question = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, exercice>
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(exercice $Question): static
    {
        if (!$this->question->contains($Question)) {
            $this->question->add($Question);
        }

        return $this;
    }

    public function removeQuestion(exercice $Question): static
    {
        $this->question->removeElement($Question);

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(user $User): static
    {
        if (!$this->user->contains($User)) {
            $this->user->add($User);
        }

        return $this;
    }

    public function removeUser(user $User): static
    {
        $this->user->removeElement($User);

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
