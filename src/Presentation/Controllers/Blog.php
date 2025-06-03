<?php

namespace Presentation\Controllers;

final class Blog extends \Presentation\MVC\Controller
{
    public function __construct(
        private \Application\MyBlogQuery $myBlogQuery,
        private \Application\CreateBlogEntryCommand $createBlogEntryCommand,
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\UserBlogQuery $userBlogQuery,
        private \Application\ToggleLikeCommand $toggleLikeCommand,
        private \Application\DeleteBlogEntryCommand $deleteBlogEntryCommand,
    ) {}

    public function GET_Index(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        $blogEntries = $this->myBlogQuery->execute();
        
        return $this->view('blog/index', [
            'user' => $user,
            'blogEntries' => $blogEntries,
            'returnUrl' => $this->getRequestUri(),
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
            'returnUrl' => $this->getRequestUri(),
        ]);
    }

    public function POST_ToggleLike(): \Presentation\MVC\ActionResult
    {
        $blogEntryId = (int)$this->getParam('id');
        $this->toggleLikeCommand->execute($blogEntryId);
        
        $returnUrl = $this->getParam('returnUrl');
        if ($returnUrl) {
            return $this->redirectToUri($returnUrl);
        }
        
        return $this->redirect('Blog', 'Index');
    }

    public function POST_Delete(): \Presentation\MVC\ActionResult
    {
        $blogEntryId = (int)$this->getParam('id');
        $this->deleteBlogEntryCommand->execute($blogEntryId);
        
        return $this->redirect('Blog', 'Index');
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