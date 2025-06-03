<?php

namespace Application;

final class UserBlogQuery
{
    public function __construct(
        private \Application\Interfaces\BlogRepository $blogRepository,
        private \Application\Interfaces\UserRepository $userRepository,
        private \Application\Services\UserService $userService,
    ) {}

    public function execute(int $userId): array
    {
        $user = $this->userRepository->getUser($userId);
        if ($user === null) {
            return [];
        }

        $currentUserId = $this->userService->getUserId();
        $blogEntries = $this->blogRepository->getBlogEntriesByUserId($userId);
        $result = [];

        foreach ($blogEntries as $entry) {
            $result[] = [
                'entry' => $entry,
                'likeCount' => $this->blogRepository->getLikeCount($entry->getId()),
                'userLiked' => $currentUserId ? $this->blogRepository->hasUserLiked($currentUserId, $entry->getId()) : false,
                'likedBy' => $this->blogRepository->getUsersWhoLiked($entry->getId())
            ];
        }

        return [
            'user' => $user,
            'blogEntries' => $result
        ];
    }
} 