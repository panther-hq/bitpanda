<?php


namespace App\Http\Controllers;


use App\Application\Query\Transaction\TransactionFactory;
use App\Exceptions\SourceTransactionIsNotImplementedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class TransactionController extends Controller
{
    private TransactionFactory $transactionFactory;

    public function __construct(TransactionFactory $transactionFactory)
    {
        $this->transactionFactory = $transactionFactory;
    }

    public function index(Request $request): JsonResponse {
        try {
            $transactions = $this->transactionFactory->findAllBySource($request->query->get('source',''));
            return new JsonResponse($transactions);
        } catch (SourceTransactionIsNotImplementedException $exception){
            return new JsonResponse('Sorry, but you are unable to read transaction data', JsonResponse::HTTP_BAD_REQUEST);
        }

    }
}
