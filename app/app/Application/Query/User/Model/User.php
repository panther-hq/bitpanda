<?php


namespace App\Application\Query\User\Model;


final class User implements \JsonSerializable
{

    private int $id;
    private string $email;
    private bool $active;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        string $email,
        bool $active,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->active = $active;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'active' => $this->active,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }


}
