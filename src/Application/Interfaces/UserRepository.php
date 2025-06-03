<?php 

namespace Application\Interfaces;

interface UserRepository
{
    public function getUser(int $userId): ?\Application\Entities\User;
    public function getUserByUserName(string $userName): ?\Application\Entities\User;
    public function addUser(string $username, string $passwordHash, string $displayName): void;
    public function isUsernameAvailable(string $username): bool;
    public function searchUsersByDisplayName(string $searchTerm): array;
}