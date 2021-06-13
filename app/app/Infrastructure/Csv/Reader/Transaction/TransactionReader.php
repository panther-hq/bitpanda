<?php


namespace App\Infrastructure\Csv\Reader\Transaction;


use App\Application\Query\Transaction\Model\Transaction;
use App\Application\Query\Transaction\TransactionQueryInterface;
use League\Csv\Reader;

final class TransactionReader implements TransactionQueryInterface
{
    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $filePath = storage_path('transaction/transactions.csv');
        $csv = Reader::createFromPath($filePath);
        $csv->setHeaderOffset(0);

        $data = [];
        foreach ($csv->getRecords($csv->getHeader()) as $record){
            $data[] = $this->hydrateTransaction($record);
        }
        return $data;
    }

    private function hydrateTransaction(array $data): Transaction
    {
        return new Transaction(
            (int)$data['id'],
            $data['code'],
            $data['amount'],
            (int)$data['user_id'],
            new \DateTimeImmutable($data['created_at']),
            new \DateTimeImmutable($data['updated_at'])
        );
    }
}
