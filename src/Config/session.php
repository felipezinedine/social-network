<?php

namespace Src\Config;

class Session 
{
    /**
     * Cria ou atualiza uma sessão.
     */
    public static function new(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Carrega uma sessão específica.
     */
    public static function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Carrega todas as sessões.
     */
    public static function getAll(): array
    {
        return $_SESSION;
    }

    /**
     * Verifica se uma sessão existe.
     */
    public static function exists(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Destrói uma sessão específica.
     */
    public static function destroy(string $key): void
    {
        if (self::exists($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destrói todas as sessões.
     */
    public static function destroyAll(): void
    {
        session_unset();
        session_destroy();
    }
}
