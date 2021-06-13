<?php


namespace App\Infrastructure\Database\Query\User;


use App\Application\Query\User\Model\UserDetail;
use App\Application\Query\User\UserDetailQueryInterface;
use App\Exceptions\UserDetailNotFoundException;
use Illuminate\Support\Facades\DB;

final class UserDetailQuery implements UserDetailQueryInterface
{
    public function getByUserId(int $userId): UserDetail
    {
        $qb = DB::table('user_details')
            ->select($this->getColumns())
            ->where('user_details.user_id','=', $userId);

        $data = $qb->get()->first();
        if ($data === null){
            throw new UserDetailNotFoundException(\sprintf('User detail with user id %s not exist', $userId));
        }
        return $this->hydrateUserDetail($data);
    }

    private function getColumns(): array
    {
        return [
            'user_details.id',
            'user_details.user_id',
            'user_details.citizenship_country_id',
            'user_details.first_name',
            'user_details.last_name',
            'user_details.phone_number',
        ];
    }

    private function hydrateUserDetail(\stdClass $data): UserDetail
    {
        return new UserDetail(
            (int)$data->id,
            (int)$data->user_id,
            (int)$data->citizenship_country_id,
            $data->first_name,
            $data->last_name,
            $data->phone_number
        );
    }
}
