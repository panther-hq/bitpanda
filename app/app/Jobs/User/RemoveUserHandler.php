<?php


namespace App\Jobs\User;


use App\Repository\User\UsersRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class RemoveUserHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private RemoveUser $removeUser;

    public function __construct(RemoveUser $removeUser)
    {
        $this->removeUser = $removeUser;
    }

    public function handle(
        UsersRepositoryInterface $usersRepository
    ): void
    {
        $user = $usersRepository->getById($this->removeUser->getUserId());
        $user->remove();
    }
}
