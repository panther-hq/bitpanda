<?php


namespace App\Infrastructure\Database\Query\Transaction;


use App\Application\Query\Transaction\Model\Transaction;
use App\Application\Query\Transaction\TransactionQueryInterface;
use Illuminate\Support\Facades\DB;

final class TransactionQuery implements TransactionQueryInterface
{
    public function findAll(): array
    {
        $qb = DB::table('transactions')
            ->select($this->getColumns());

        return \array_map(function (\stdClass $data): Transaction {
            return $this->hydrateTransaction($data);
        }, $qb->get()->toArray());
    }

    private function getColumns(): array
    {
        return [
            'transactions.id',
            'transactions.code',
            'transactions.amount',
            'transactions.user_id',
            'transactions.created_at',
            'transactions.updated_at',
        ];
    }

    private function hydrateTransaction(\stdClass $data): Transaction
    {
        return new Transaction(
            (int)$data->id,
            $data->code,
            $data->amount,
            (int)$data->user_id,
            new \DateTimeImmutable($data->created_at),
            new \DateTimeImmutable($data->updated_at)
        );
    }
}
