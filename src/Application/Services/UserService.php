<?php

namespace Application\Services;

final class UserService
{
    public function __construct(
        private \Application\Interfaces\Session $session,
    ) {}

    public function getUserId(): ?int
    {
        return $this->session->get('userId');
    }

    public function isAuthenticated(): bool //hasUser
    {
        return $this->getUserId() !== null;
    }

    public function signIn(int $userId): void
    {
       $this->session->put('userId', $userId);
    }

    public function signOut(): void
    {
        $this->session->delete('userId');
    }
} 