<?php

namespace App\Model\Exercice;

use App\Entity\Exercice;

/**
 * Class ExerciceModel
 * @package App\Model\Exercice
 */
class ExerciceModel
{
    /**
     * @var ?int
     */
    public ?int $id;

    /**
     * @var ?string
     */
    private ?string $question;

    /**
     * @var ?string
     */
    private ?string $category;

    /**
     * @var ?string
     */
    private ?string $first_answer;

    /**
     * @var ?string
     */
    private ?string $second_answer;

    /**
     * @var ?string
     */
    private ?string $third_answer;

    /**
     * @var ?string
     */
    private ?string $correct_answer;

    /**
     * @var ?string
     */
    private ?string $difficulty;

    /**
     * Exercice constructor.
     * @param Exercice $exercice
     */
    public function __construct(Exercice $exercice)
    {
        $this->id = $exercice->getId() ?? null;
        $this->question = $exercice->getQuestion() ?? null;
        $this->category = $exercice->getCategory() ?? null;
        $this->first_answer = $exercice->getFirstAnswer() ?? null;
        $this->second_answer = $exercice->getSecondAnswer() ?? null;
        $this->third_answer = $exercice->getThirdAnswer() ?? null;
        $this->correct_answer = $exercice->getCorrectAnswer() ?? null;
        $this->difficulty = $exercice->getDifficulty() ?? null;
    }

    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return ?string
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @return ?string
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return ?string
     */
    public function getFirstAnswer(): ?string
    {
        return $this->first_answer;
    }

    /**
     * @return ?string
     */
    public function getSecondAnswer(): ?string
    {
        return $this->second_answer;
    }

    /**
     * @return ?string
     */
    public function getThirdAnswer(): ?string
    {
        return $this->third_answer;
    }

    /**
     * @return ?string
     */
    public function getCorrectAnswer(): ?string
    {
        return $this->correct_answer;
    }

    /**
     * @return ?string
     */
    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }
}
