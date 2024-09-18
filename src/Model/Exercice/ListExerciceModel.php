<?php

namespace App\Model\Exercice;

use App\Entity\Exercice;
use Doctrine\Common\Collections\ArrayCollection;

class ListExerciceModel
{
    /**
     * @var ArrayCollection|ExerciceModel[]
     */
    private $exercices;

    /**
     * ListExerciceModel constructor.
     * @param Exercice[] $exercices
     */
    public function __construct(array $exercices)
    {
        $this->exercices = new ArrayCollection();

        foreach ($exercices as $exercice) {
            $this->exercices->add(new ExerciceModel($exercice));
        }
    }

    /**
     * @return ArrayCollection|ExerciceModel[]
     */
    public function getExercices(): ArrayCollection|array
    {
        return $this->exercices;
    }
}