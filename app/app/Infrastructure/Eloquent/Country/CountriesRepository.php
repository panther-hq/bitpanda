<?php


namespace App\Infrastructure\Eloquent\Country;


use App\Exceptions\CountryNotFoundException;
use App\Models\Country;
use App\Repository\Country\CountriesRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

final class CountriesRepository implements CountriesRepositoryInterface
{

    private Country|Builder $country;

    public function __construct(
        Country $country
    )
    {
        $this->country = $country;
    }

    public function getById(int $id): Country
    {
        $country = $this->country->find($id);
        if (!$country instanceof Country){
            throw new CountryNotFoundException(\sprintf('Country with id %s not exist', $id));
        }
        return $country;
    }

}
