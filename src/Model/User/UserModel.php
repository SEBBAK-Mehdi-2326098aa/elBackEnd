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
    public ?int $id;
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
     *@var ?int
     */
    private ?int $level;
    /**
     * User constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->id = $user->getId() ?? null;
        $this->name = $user->getName() ?? null;
        $this->lastname = $user->getLastname() ?? null;
        $this->email = $user->getEmail() ?? null;
        $this->password = $user->getPassword() ?? null;
        $this->civility = $user->getCivility() ?? null;
        $this->level = $user->getLevel() ?? null;
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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): void
    {
        $this->level = $level;
    }

}
