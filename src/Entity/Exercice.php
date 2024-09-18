<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ExerciceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
#[ApiResource]
class Exercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(length: 50)]
    private ?string $category = null;

    #[ORM\Column(length: 50)]
    private ?string $first_answer = null;

    #[ORM\Column(length: 50)]
    private ?string $second_answer = null;

    #[ORM\Column(length: 50)]
    private ?string $third_answer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getFirstAnswer(): ?string
    {
        return $this->first_answer;
    }

    public function setFirstAnswer(string $first_answer): static
    {
        $this->first_answer = $first_answer;

        return $this;
    }

    public function getSecondAnswer(): ?string
    {
        return $this->second_answer;
    }

    public function setSecondAnswer(string $second_answer): static
    {
        $this->second_answer = $second_answer;

        return $this;
    }

    public function getThirdAnswer(): ?string
    {
        return $this->third_answer;
    }

    public function setThirdAnswer(string $third_answer): static
    {
        $this->third_answer = $third_answer;

        return $this;
    }
}
