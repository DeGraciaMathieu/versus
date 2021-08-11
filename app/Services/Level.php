<?php

namespace App\Services;

use DevMakerLab\Entity;

class Level extends Entity
{
    public array $range;
    public int $speed;
    public string $name;
}
