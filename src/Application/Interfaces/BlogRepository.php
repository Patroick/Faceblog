<?php 

namespace Application\Interfaces;

interface BlogRepository
{
    public function getBlogEntriesByUserId(int $userId): array;
    public function addBlogEntry(int $userId, string $subject, string $content): void;
    public function toggleLike(int $userId, int $blogEntryId): void;
    public function getLikeCount(int $blogEntryId): int;
    public function hasUserLiked(int $userId, int $blogEntryId): bool;
    public function getUsersWhoLiked(int $blogEntryId): array;
    public function deleteBlogEntry(int $blogEntryId, int $userId): bool;
} 