<?php

namespace Application\Entities;

final class User
{
    public function __construct(
        private int $id,
        private string $username,
        private string $passwordHash
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
} 