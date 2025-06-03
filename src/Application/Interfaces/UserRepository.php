<?php 

namespace Application\Interfaces;

interface UserRepository
{
    public function getUser(int $userId): ?\Application\Entities\User;
    public function getUserByUserName(string $userName): ?\Application\Entities\User;
    //public function addUser(\Application\Entities\UserData $user): void;
}