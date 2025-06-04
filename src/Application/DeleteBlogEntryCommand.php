<?php

namespace Application;

final class DeleteBlogEntryCommand
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
        return $this->blogRepository->deleteBlogEntry($blogEntryId, $userId);
    }
} 