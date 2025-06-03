<?php

namespace Infrastructure;

final class Session implements \Application\Interfaces\Session
{
    public function __construct()
    {
        // if (session_status() === PHP_SESSION_NONE) {
        //     session_start();
        // }
        session_start();
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }
}