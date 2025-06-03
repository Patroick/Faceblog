<?php

namespace Application;

readonly class UserData
{
    public function __construct(
        private int $id,
        private string $userName,
        private string $displayName
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->userName;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }
} 