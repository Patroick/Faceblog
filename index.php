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

// --- Presentation
$sp->register(\Presentation\MVC\MVC::class, implementation: function() { return new \Presentation\MVC\MVC(); });
$sp->register(\Presentation\Controllers\Home::class);

// --- Infrastructure
$sp->register(\Infrastructure\DatabaseRepository::class, implementation: function() { 
    return new \Infrastructure\DatabaseRepository('localhost', 'root', '', 'faceblog'); 
});

$sp->register(\Application\Interfaces\StatisticsRepository::class, implementation: \Infrastructure\DatabaseRepository::class);

// TODO: handle request
$sp->resolve(\Presentation\MVC\MVC::class)
   ->handleRequest($sp);
