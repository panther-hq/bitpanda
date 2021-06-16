<?php


namespace App\Jobs\User;


final class EditUser
{
    private int $userId;
    private int $citizenshipCountryId;
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;

    public function __construct(
        int $userId,
        int $citizenshipCountryId,
        string $firstName,
        string $lastName,
        string $phoneNumber
    )
    {
        $this->userId = $userId;
        $this->citizenshipCountryId = $citizenshipCountryId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCitizenshipCountryId(): int
    {
        return $this->citizenshipCountryId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}
