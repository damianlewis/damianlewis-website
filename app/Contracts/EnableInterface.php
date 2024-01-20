<?php

namespace App\Contracts;

interface EnableInterface
{
    public function enable(): void;

    public function disable(): void;
}
