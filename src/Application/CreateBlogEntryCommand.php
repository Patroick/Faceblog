<?php

namespace Application;

final class CreateBlogEntryCommand
{
    public function __construct(
        private \Application\Services\UserService $userService,
        private \Application\Interfaces\BlogRepository $blogRepository,
    ) {}

    public function execute(string $subject, string $content): array
    {
        $errors = [];

        if (empty(trim($subject))) {
            $errors[] = 'Betreff ist erforderlich';
        }

        if (empty(trim($content))) {
            $errors[] = 'Inhalt ist erforderlich';
        }

        $userId = $this->userService->getUserId();

        if (empty($errors)) {
            $this->blogRepository->addBlogEntry($userId, $subject, $content);
        }

        return $errors;
    }
} 