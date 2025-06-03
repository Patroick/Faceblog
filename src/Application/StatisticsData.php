<?php

namespace Application;

final readonly class StatisticsData
{
    public string $formattedLastPostDate;
    
    public function __construct(
        public int $userCount,
        public int $totalBlogEntries,
        public int $recentBlogEntries,
        public ?string $lastPostDate
    ) {
        $this->formattedLastPostDate = date('d.m.Y H:i', strtotime($lastPostDate));
    }
} 