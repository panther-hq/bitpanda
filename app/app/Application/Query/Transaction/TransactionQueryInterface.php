<?php


namespace App\Application\Query\Transaction;


use App\Application\Query\Transaction\Model\Transaction;

interface TransactionQueryInterface
{
    /**
     * @return Transaction[]
     */
    public function findAll(): array;
}
