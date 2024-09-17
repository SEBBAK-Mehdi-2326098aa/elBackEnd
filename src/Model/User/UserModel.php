<?php

namespace App\Model\User;

use App\Entity\User;

/**
 * Class UserModel
 * @package App\Model\User
 */
class UserModel
{
    /**
     * @var ?int
     */
    public ?int $id;  // Ce type permet d'accepter null ou int
    /**
     * @var ?string
     */
    private ?string $name;

    /**
     * @var ?string
     */
    private ?string $lastname;

    /**
     * @var ?string
     */
    private ?string $email;

    /**
     * @var ?string
     */
    private ?string $password;

    /**
     * @var ?string
     */
    private ?string $civility;

    /**
     * User constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->id = $user->getId() ?? null;  // Gérer l'assignation de null
        $this->name = $user->getName() ?? null;
        $this->lastname = $user->getLastname() ?? null;
        $this->email = $user->getEmail() ?? null;
        $this->password = $user->getPassword() ?? null;
        $this->civility = $user->getCivility() ?? null;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return ?string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return ?string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return ?string
     */
    public function getCivility(): ?string
    {
        return $this->civility;
    }
}
