<?php
// === register autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php'; // dont know if it work in linux replace
    if (file_exists($file)) {
        require_once($file);
    }
});

$sp = new \ServiceProvider(); // root namespace else it search in no namespace

// === register services

// --- Application
$sp->register(\Application\StatisticsQuery::class);
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\SignOutCommand::class);
$sp->register(\Application\SignedInUserQuery::class);
$sp->register(\Application\RegisterCommand::class);
$sp->register(\Application\MyBlogQuery::class);
$sp->register(\Application\CreateBlogEntryCommand::class);
$sp->register(\Application\PeopleQuery::class);

// --- Services
$sp->register(\Application\Services\UserService::class);

// --- Presentation
$sp->register(\Presentation\MVC\MVC::class, implementation: function() { return new \Presentation\MVC\MVC(); });
$sp->register(\Presentation\Controllers\Home::class);
$sp->register(\Presentation\Controllers\User::class);
$sp->register(\Presentation\Controllers\Blog::class);
$sp->register(\Presentation\Controllers\People::class);

// --- Infrastructure
$sp->register(\Infrastructure\DatabaseRepository::class, implementation: function() { 
    return new \Infrastructure\DatabaseRepository('localhost', 'root', '', 'faceblog'); 
});

$sp->register(\Infrastructure\Session::class, isSingleton: true);

$sp->register(\Application\Interfaces\StatisticsRepository::class, implementation: \Infrastructure\DatabaseRepository::class);
$sp->register(\Application\Interfaces\UserRepository::class, implementation: \Infrastructure\DatabaseRepository::class);
$sp->register(\Application\Interfaces\BlogRepository::class, implementation: \Infrastructure\DatabaseRepository::class);
$sp->register(\Application\Interfaces\Session::class, implementation: \Infrastructure\Session::class);

// TODO: handle request
$sp->resolve(\Presentation\MVC\MVC::class)
   ->handleRequest($sp);
