<?php 

namespace Application\Interfaces;

interface BlogRepository
{
    public function getBlogEntriesByUserId(int $userId): array;
    public function addBlogEntry(int $userId, string $subject, string $content): void;
} 