<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Country extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'countries';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    public function getId(): int
    {
        return (int)$this->getAttribute('id');
    }

}
