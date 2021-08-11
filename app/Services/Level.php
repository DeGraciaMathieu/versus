<?php

namespace App\Services;

use DevMakerLab\Entity;

class Level extends Entity
{
    public int $range;
    public int $speed;
    public string $name;
}
