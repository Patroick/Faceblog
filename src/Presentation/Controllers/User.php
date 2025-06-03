<?php

namespace Presentation\Controllers;

final class User extends \Presentation\MVC\Controller
{
    public function __construct(
        private \Application\SignInCommand $signInCommand,
        private \Application\SignOutCommand $signOutCommand,
        private \Application\SignedInUserQuery $signedInUserQuery,
    )
    {}

    public function GET_LogIn(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        return $this->view('login',[
            'username' => '',
            'user' => $user !== null ? ['username' => $user->getName()] : null,
        ]);
    }

    public function POST_LogIn() : \Presentation\MVC\ActionResult
    {

        $ok = $this->signInCommand->execute(
            $this->getParam('un'),
            $this->getParam('pwd')
        );

        if (!$ok) {
            $user = $this->signedInUserQuery->execute();
            return $this->view('login', [
                'user' => $user !== null ? ['username' => $user->getName()] : null,
                'username' => $this->getParam('un'),
                'errors' => ['Invalid username or password'],
            ]);
        } 

        return $this->redirect('Home', 'Index'); //TODO retrun to previous page - implement pattern
    }

    public function GET_Register(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        return $this->view('register', [
            'user' => $user !== null ? ['username' => $user->getName()] : null,
        ]);
    }

    public function POST_LogOut() : \Presentation\MVC\ActionResult
    {
        // Todo with returnUrl to redirect to the page where the user was
        // before logging out
        echo "LogOut";
        $this->signOutCommand->execute();
        return $this->redirect('Home', "Index"); //TODO retrun to previous page - implement pattern
    }
} 