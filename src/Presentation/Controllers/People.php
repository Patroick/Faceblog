<?php

namespace Presentation\Controllers;

final class People extends \Presentation\MVC\Controller
{
    public function __construct(
        private \Application\PeopleQuery $peopleQuery,
        private \Application\SignedInUserQuery $signedInUserQuery,
    ) {}

    public function GET_Index(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        
        return $this->view('people/index', [
            'user' => $user,
            'searchTerm' => $this->tryGetParam('search', $searchTerm) ? $searchTerm : '',
            'people' => $this->tryGetParam('search', $searchTerm) ? $this->peopleQuery->execute($searchTerm) : [],
        ]);
    }
} 