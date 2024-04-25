<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\UserRoles;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
final readonly class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    public Uuid $id;

    #[ORM\Column(type: 'string', length: 255)]
    public string $fullname;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    public string $login;

    #[ORM\Column(type: 'string', length: 255)]
    public string $password;

    #[ORM\Column(type: 'json')]
    public array $roles;

    public function __construct(
        string $fullname,
        string $login,
        string $password
    )
    {
        $this->id = Uuid::v4();
        $this->fullname = $fullname;
        $this->login = $login;
        $this->password = $password;
        $this->roles = [UserRoles::RoleUser->value];
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = UserRoles::RoleUser->value;

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
