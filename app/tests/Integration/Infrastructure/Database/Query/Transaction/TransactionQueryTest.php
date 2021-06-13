<?php


namespace Tests\Integration\Infrastructure\Database\Query\Transaction;


use App\Infrastructure\Database\Query\Transaction\TransactionQuery;
use Tests\TestCase;

final class TransactionQueryTest extends TestCase
{

    public function test_find_all(): void
    {
        $transactions = $this->app->get(TransactionQuery::class)->findAll();
        $this->assertCount(100, $transactions);
    }
}
