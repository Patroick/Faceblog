<?php

namespace Application;

final class MyBlogQuery
{
    public function __construct(
        private \Application\Services\UserService $userService,
        private \Application\Interfaces\BlogRepository $blogRepository,
    ) {}

    public function execute(): array
    {
        $userId = $this->userService->getUserId();
        if ($userId === null) {
            return [];
        }

        return $this->blogRepository->getBlogEntriesByUserId($userId);
    }
} 