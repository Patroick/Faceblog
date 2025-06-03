<?php

namespace Application\Entities;

final class User
{
    public function __construct(
        private int $id,
        private string $username,
        private string $passwordHash,
        private string $displayName,
        private string $createdAt
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

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
} 