<?php


namespace Tests\Integration\Infrastructure\Csv\Reader\Transaction;


use App\Infrastructure\Csv\Reader\Transaction\TransactionReader;
use Tests\TestCase;

final class TransactionReaderTest extends TestCase
{
    public function test_find_all(): void
    {
        $transactions = $this->app->get(TransactionReader::class)->findAll();
        $this->assertCount(100, $transactions);
    }
}
