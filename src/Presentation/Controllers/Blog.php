<?php

namespace Presentation\Controllers;

final class Blog extends \Presentation\MVC\Controller
{
    public function __construct(
        private \Application\MyBlogQuery $myBlogQuery,
        private \Application\CreateBlogEntryCommand $createBlogEntryCommand,
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\UserBlogQuery $userBlogQuery,
    ) {}

    public function GET_Index(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        $blogEntries = $this->myBlogQuery->execute();
        
        return $this->view('blog/index', [
            'user' => $user,
            'blogEntries' => $blogEntries,
        ]);
    }

    public function GET_User(): \Presentation\MVC\ActionResult
    {
        $currentUser = $this->signedInUserQuery->execute();
        $userId = (int)$this->getParam('id');
        $result = $this->userBlogQuery->execute($userId);
        
        return $this->view('blog/user', [
            'user' => $currentUser,
            'blogUser' => $result['user'] ?? null,
            'blogEntries' => $result['blogEntries'] ?? [],
        ]);
    }

    public function GET_Create(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        return $this->view('blog/create', [
            'user' => $user,
        ]);
    }

    public function POST_Create(): \Presentation\MVC\ActionResult
    {
        $errors = $this->createBlogEntryCommand->execute(
            $this->getParam('subject'),
            $this->getParam('content')
        );

        if (!empty($errors)) {
            $user = $this->signedInUserQuery->execute();
            return $this->view('blog/create', [
                'user' => $user,
                'subject' => $this->getParam('subject'),
                'content' => $this->getParam('content'),
                'errors' => $errors,
            ]);
        }

        return $this->redirect('Blog', 'Index');
    }
} 