<?php

namespace Application;

use Application\UserData;

final class SignedInUserQuery
{
    public function __construct(
        private \Application\Services\UserService $userService,
        private \Application\Interfaces\UserRepository $userRepository,
    ) {}

    public function execute(): ?UserData
    {
        $id = $this->userService->getUserId();
        if ($id === null) {
            return null;
        }

        $user = $this->userRepository->getUser($id);

        if ($user === null) {
            return null;
        }

        return new \Application\UserData($user->getId(), $user->getUserName());
    }
} 