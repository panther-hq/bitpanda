<?php


namespace App\Repository\Country;


use App\Models\Country;

interface CountriesRepositoryInterface
{
    public function getById(int $id): Country;
}
