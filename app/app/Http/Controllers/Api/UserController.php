<?php


namespace App\Http\Controllers\Api;


use App\Application\Query\User\Filter;
use App\Application\Query\User\UserQueryInterface;
use App\Exceptions\CountryNotFoundException;
use App\Exceptions\RuntimeException;
use App\Exceptions\UserDetailNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Jobs\User\EditUser;
use App\Jobs\User\EditUserHandler;
use App\Jobs\User\RemoveUser;
use App\Jobs\User\RemoveUserHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class UserController extends Controller
{


    private UserQueryInterface $userQuery;

    public function __construct(UserQueryInterface $userQuery)
    {
        $this->userQuery = $userQuery;
    }

    public function lists(Request $request): JsonResponse
    {
        $filter = (new Filter());
        if (null !== $request->query->get('isActive')){
            $filter->setActive(filter_var($request->query->get('isActive'), FILTER_VALIDATE_BOOLEAN ));
        }
        if (null !== $request->query->get('iso3')){
            $filter->setIso3($request->query->get('iso3'));
        }
        $users = $this->userQuery->findAll($filter);
        return new JsonResponse($users);
    }

    public function edit(Request $request, int $userId): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE){
            return new JsonResponse('Incorrect data', JsonResponse::HTTP_BAD_REQUEST);
        }
        $rules = [
            'firstName' => 'required',
            'lastName' => 'required',
            'phoneNumber' => 'required',
            'countryId' => 'required|numeric|min:1'
        ];

        $validator = Validator::make($data, $rules);
        if (!$validator->passes()){
            return new JsonResponse($validator->errors()->all(), JsonResponse::HTTP_BAD_REQUEST);
        }
        $editUser = new EditUser(
            $userId,
            (int)$data['countryId'],
            $data['firstName'],
            $data['lastName'],
            $data['phoneNumber']
        );
        try {
            EditUserHandler::dispatch($editUser);
        } catch (UserDetailNotFoundException $exception) {
            return new JsonResponse('The user cannot be edit because it has\'t detailed data', JsonResponse::HTTP_BAD_REQUEST);
        } catch (UserNotFoundException $exception){
            return new JsonResponse('User does not exist', JsonResponse::HTTP_BAD_REQUEST);
        } catch (CountryNotFoundException $exception){
            return new JsonResponse('Country does not exist', JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse('data was saved successfully', JsonResponse::HTTP_OK);
    }

    public function remove(int $userId): JsonResponse
    {
        $removeUser = new RemoveUser(
            $userId
        );
        try {
            RemoveUserHandler::dispatch($removeUser);
        } catch (RuntimeException $exception){
            return new JsonResponse('The user cannot be deleted because it has detailed data', JsonResponse::HTTP_BAD_REQUEST);
        } catch (UserNotFoundException $exception){
            return new JsonResponse('User does not exist', JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
