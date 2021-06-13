<?php

namespace App\Models;

use App\Exceptions\RuntimeException;
use App\Exceptions\UserDetailNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class User extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    public function userDetail(): UserDetail
    {
        $userDetail = $this->hasOne(UserDetail::class)->get()->first();
        if (!$userDetail instanceof UserDetail){
            throw new UserDetailNotFoundException(\sprintf('User detail with user id %s not exist', $this->getId()));
        }
        return $userDetail;
    }

    public function getId(): int
    {
        return (int)$this->getAttribute('id');
    }

    public function getEmail(): string
    {
        return $this->getAttribute('email');
    }

    public function isActive(): bool
    {
        return \filter_var($this->getAttribute('active'), FILTER_VALIDATE_BOOLEAN);
    }

    public function getCreatedAt(): string
    {
        return new \DateTimeImmutable($this->getAttribute('created_at'));
    }

    public function getUpdatedAt(): string
    {
        return new \DateTimeImmutable($this->getAttribute('updated_at'));
    }

    public function remove(): void
    {
        try {
            $this->userDetail();
            throw new RuntimeException(sprintf('User with id %s has detailed data', $this->getId()));
        } catch (UserDetailNotFoundException $exception) {}
        $this->delete();
    }

    public function edit(
        int $citizenshipCountryId,
        string $firstName,
        string $lastName,
        string $phoneNumber
    ): void
    {
        $this->userDetail()->edit(
            $citizenshipCountryId,
            $firstName,
            $lastName,
            $phoneNumber
        );
    }


}
