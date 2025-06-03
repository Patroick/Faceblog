<?php

namespace Application;

final class StatisticsQuery
{
    public function __construct(
        private \Application\Interfaces\StatisticsRepository $statisticsRepository
    ) {}

    public function execute(): StatisticsData
    {
        return new StatisticsData(
            $this->statisticsRepository->getTotalUserCount(),
            $this->statisticsRepository->getTotalBlogEntriesCount(),
            $this->statisticsRepository->getRecentBlogEntriesCount(),
            $this->statisticsRepository->getLastPostDate()
        );
    }
} 