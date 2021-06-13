<?php


namespace Tests\Feature\Http\Controller;


use Illuminate\Http\JsonResponse;
use Tests\TestCase;

final class TransactionController extends TestCase
{

    public function test_return_json_with_transaction_data(): void
    {
        $data = $this->get('/transactions?source=db');
        $data->assertJsonCount(100);
        $data->assertStatus(JsonResponse::HTTP_OK);

        $data = $this->get('/transactions?source=csv');
        $data->assertJsonCount(100);
        $data->assertStatus(JsonResponse::HTTP_OK);
    }

    public function test_not_return_json_with_transaction_data(): void
    {
        $data = $this->get('/transactions?source=xlsx');
        $data->assertStatus(JsonResponse::HTTP_BAD_REQUEST);

        $data = $this->get('/transactions');
        $data->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }
}
