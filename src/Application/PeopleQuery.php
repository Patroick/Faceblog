<?php

namespace Application;

final class PeopleQuery
{
    public function __construct(
        private \Application\Interfaces\UserRepository $userRepository,
    ) {}

    public function execute(string $searchTerm): array
    {
        if (empty(trim($searchTerm))) {
            return [];
        }

        return $this->userRepository->searchUsersByDisplayName($searchTerm);
    }
} 