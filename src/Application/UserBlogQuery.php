<?php

namespace Application;

final class UserBlogQuery
{
    public function __construct(
        private \Application\Interfaces\BlogRepository $blogRepository,
        private \Application\Interfaces\UserRepository $userRepository,
    ) {}

    public function execute(int $userId): array
    {
        $user = $this->userRepository->getUser($userId);
        if ($user === null) {
            return [];
        }

        return [
            'user' => $user,
            'blogEntries' => $this->blogRepository->getBlogEntriesByUserId($userId)
        ];
    }
} 