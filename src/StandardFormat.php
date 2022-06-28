<?php

namespace Skies\LeBang;

class StandardFormat
{
    public function __construct(public string $name, public array $images, public string|array $desc)
    {
    }
}
