<?php

namespace Presentation\Controllers;

final class User extends \Presentation\MVC\Controller
{
    public function __construct(
        private \Application\SignInCommand $signInCommand,
        private \Application\SignOutCommand $signOutCommand,
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\RegisterCommand $registerCommand,
    )
    {}

    public function GET_LogIn(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        return $this->view('login',[
            'username' => '',
            'user' => $user,
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
                'user' => $user,
                'username' => $this->getParam('un'),
                'errors' => ['Ungültiger Benutzername oder Passwort'],
            ]);
        } 

        return $this->redirect('Home', 'Index');
    }

    public function GET_Register(): \Presentation\MVC\ActionResult
    {
        return $this->view('register', [
            'user' => null,
        ]);
    }

    public function POST_Register(): \Presentation\MVC\ActionResult
    {
        $errors = $this->registerCommand->execute(
            $this->getParam('username'),
            $this->getParam('password'),
            $this->getParam('displayName')
        );

        if (!empty($errors)) {
            $user = $this->signedInUserQuery->execute();
            return $this->view('register', [
                'user' => $user,
                'username' => $this->getParam('username'),
                'displayName' => $this->getParam('displayName'),
                'errors' => $errors,
            ]);
        }

        $this->signInCommand->execute(
            $this->getParam('username'),
            $this->getParam('password')
        );

        return $this->redirect('Home', 'Index');
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