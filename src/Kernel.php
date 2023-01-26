<?php

// src/Kernel.php
namespace App;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    // ...

    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }
}