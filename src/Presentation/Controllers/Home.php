<?php

namespace Presentation\Controllers;

final class Home extends \Presentation\MVC\Controller
{
    public function __construct(
        private \Application\StatisticsQuery $statisticsQuery,
        private \Application\SignedInUserQuery $signedInUserQuery,
    ) {}

    public function GET_Index(): \Presentation\MVC\ActionResult
    {
        $statistics = $this->statisticsQuery->execute();
        $user = $this->signedInUserQuery->execute();
        
        return $this->view('home', [
            'statistics' => $statistics,
            'user' => $user,
        ]);
    }
} 