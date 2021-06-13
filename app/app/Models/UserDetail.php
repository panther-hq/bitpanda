<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class UserDetail extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'user_details';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $timestamps = false;

    public function edit(
        int $citizenshipCountryId,
        string $firstName,
        string $lastName,
        string $phoneNumber
    ): void
    {
        $this->citizenship_country_id = $citizenshipCountryId;
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->phone_number = $phoneNumber;
        $this->save();
    }
}
