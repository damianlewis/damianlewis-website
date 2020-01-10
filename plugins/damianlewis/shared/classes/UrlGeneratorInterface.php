<?php

declare(strict_types=1);

namespace DamianLewis\Shared\Classes;

interface UrlGeneratorInterface
{
    /**
     * Sets the base path.
     *
     * @param  string  $path
     */
    public function setBasePath(string $path): void;
}