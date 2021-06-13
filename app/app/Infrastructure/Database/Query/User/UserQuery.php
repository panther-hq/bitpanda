<?php


namespace App\Infrastructure\Database\Query\User;


use App\Application\Query\User\Filter;
use App\Application\Query\User\Model\User;
use App\Application\Query\User\UserQueryInterface;
use App\Exceptions\UserNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

final class UserQuery implements UserQueryInterface
{

    /**
     * @inheritDoc
     */
    public function findAll(Filter $filter): array
    {
        $qb = DB::table('users')
            ->select($this->getColumns());
        $qb = $this->criteria($qb, $filter);

        return \array_map(function (\stdClass $data): User {
            return $this->hydrateUser($data);
        }, $qb->get()->toArray());
    }

    public function getById(int $id): User
    {
        $qb = DB::table('users')
            ->select($this->getColumns())
            ->where('users.id','=', $id);

        $data = $qb->get()->first();
        if ($data === null){
            throw new UserNotFoundException(\sprintf('User detail with user id %s not exist', $id));
        }
        return $this->hydrateUser($data);
    }


    private function criteria(Builder $qb, Filter $filter): Builder
    {
        if ($filter->hasActive()){
            $qb->where('users.active','=',$filter->isActive());
        }
        if ($filter->hasIso3()){
            $qb->join('user_details','user_details.user_id','=', 'users.id')
                ->join('countries','user_details.citizenship_country_id','=', 'countries.id')
                ->where('countries.iso3','=',$filter->getIso3());
        }
        return $qb;
    }

    private function getColumns(): array
    {
        return [
            'users.id',
            'users.email',
            'users.active',
            'users.created_at',
            'users.updated_at',
        ];
    }

    private function hydrateUser(\stdClass $data): User
    {
        return new User(
            (int)$data->id,
            $data->email,
            filter_var($data->active, FILTER_VALIDATE_BOOLEAN),
            new \DateTimeImmutable($data->created_at),
            new \DateTimeImmutable($data->updated_at)
        );
    }
}
