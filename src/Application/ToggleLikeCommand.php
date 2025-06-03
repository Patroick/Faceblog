<?php

namespace Application;

final class ToggleLikeCommand
{
    public function __construct(
        private \Application\Services\UserService $userService,
        private \Application\Interfaces\BlogRepository $blogRepository,
    ) {}

    public function execute(int $blogEntryId): bool
    {
        $userId = $this->userService->getUserId();
        if ($userId === null) {
            return false;
        }

        $this->blogRepository->toggleLike($userId, $blogEntryId);
        return true;
    }
} 