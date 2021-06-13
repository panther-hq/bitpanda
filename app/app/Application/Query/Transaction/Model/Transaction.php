<?php


namespace App\Application\Query\Transaction\Model;


final class Transaction implements \JsonSerializable
{
    private int $id;
    private string $code;
    private string $amount;
    private int $userId;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        string $code,
        string $amount,
        int $userId,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    )
    {
        $this->id = $id;
        $this->code = $code;
        $this->amount = $amount;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getUserId(): int
    {
        return $this->userId;
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
            'id'=>$this->id,
            'code'=>$this->code,
            'amount'=>$this->amount,
            'userId'=>$this->userId,
            'createdAt'=>$this->createdAt,
            'updatedAt'=>$this->updatedAt,
        ];
    }


}
