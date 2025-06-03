<?php

namespace Application;

final class RegisterCommand
{
    public function __construct(
        private \Application\Interfaces\UserRepository $userRepository
    ) {}

    public function execute(string $username, string $password, string $displayName): array
    {
        $errors = [];

        if (empty(trim($username))) {
            $errors[] = 'Benutzername ist erforderlich';
        } elseif (!$this->userRepository->isUsernameAvailable($username)) {
            $errors[] = 'Benutzername ist bereits vergeben';
        }

        if (empty(trim($password))) {
            $errors[] = 'Passwort ist erforderlich';
        } 

        if (empty(trim($displayName))) {
            $errors[] = 'Anzeigename ist erforderlich';
        }

        if (empty($errors)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $this->userRepository->addUser($username, $passwordHash, $displayName);
        }

        return $errors;
    }
} 