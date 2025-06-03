<?php

namespace Application\Entities;

final class BlogEntry
{
    public function __construct(
        private int $id,
        private int $userId,
        private string $subject,
        private string $content,
        private string $createdAt
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
} 