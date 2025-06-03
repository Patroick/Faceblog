<?php

namespace Application;

final class SignOutCommand
{
    public function __construct(
        private \Application\Services\UserService $userService,
    ) {}

    public function execute(): void
    {
        $this->userService->signOut();
    }
} 