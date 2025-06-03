<?php

namespace Application\Interfaces;

interface StatisticsRepository
{
    public function getTotalUserCount(): int;
    public function getTotalBlogEntriesCount(): int;
    public function getRecentBlogEntriesCount(): int;
    public function getLastPostDate(): ?string;
} 