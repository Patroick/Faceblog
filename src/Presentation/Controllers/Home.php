<?php

namespace Presentation\Controllers;

use Application\StatisticsQuery;
use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

final class Home extends Controller
{
    public function __construct(
        private StatisticsQuery $statisticsQuery
    ) {}

    public function GET_Index(): ActionResult
    {
        $statistics = $this->statisticsQuery->execute();
        
        return $this->view('home', [
            'statistics' => $statistics,
            'user' => null, // TODO: implement user authentication later
        ]);
    }
} 