<?php


namespace App\Application\Query\Transaction;


use App\Application\Query\Transaction\Model\Transaction;
use App\Exceptions\SourceTransactionIsNotImplementedException;
use App\Infrastructure\Csv\Reader\Transaction\TransactionReader;
use App\Infrastructure\Database\Query\Transaction\TransactionQuery;

final class TransactionFactory
{
    public const SOURCE_CSV = 'csv';
    public const SOURCE_DATABASE = 'db';

    private TransactionReader $transactionReader;
    private TransactionQuery $transactionQuery;

    public function __construct(
        TransactionReader $transactionReader,
        TransactionQuery $transactionQuery
    )
    {
        $this->transactionReader = $transactionReader;
        $this->transactionQuery = $transactionQuery;
    }

    /**
     * @return Transaction[]
     */
    public function findAllBySource(string $source): array
    {
        switch ($source) {
            case self::SOURCE_CSV:
                $transaction = $this->transactionReader;
                break;
            case self::SOURCE_DATABASE:
                $transaction = $this->transactionQuery;
                break;
            default:
                throw new SourceTransactionIsNotImplementedException(\sprintf('Transaction with source %s is not yet implemented', $source));
        }

        return $transaction->findAll();
    }
}
