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

        $blogEntries = $this->blogRepository->getBlogEntriesByUserId($userId);
        $result = [];

        foreach ($blogEntries as $entry) {
            $result[] = [
                'entry' => $entry,
                'likeCount' => $this->blogRepository->getLikeCount($entry->getId()),
                'userLiked' => $this->blogRepository->hasUserLiked($userId, $entry->getId()),
                'likedBy' => $this->blogRepository->getUsersWhoLiked($entry->getId())
            ];
        }

        return $result;
    }
} 