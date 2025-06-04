<?php

namespace Application;

final class SignInCommand
{
    public function __construct(
        private \Application\Services\UserService $userService,
        private \Application\Interfaces\UserRepository $userRepository,
    ) {}

    public function execute(string $userName, string $password): bool
    {
        $this->userService->signOut();
        $user = $this->userRepository->getUserByUserName($userName);
        if ($user !== null && password_verify($password, $user->getPasswordHash())) {
            $this->userService->signIn($user->getId());
            return true;
        } 

        return false;
    }
} 