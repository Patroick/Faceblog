<?php

namespace Application\Interfaces;

interface Session
{
    public function get(string $key): mixed; // mixed is a type that can be any type
    public function put(string $key, mixed $value): void;
    public function delete(string $key): void;
    // public function clear(): void;
}