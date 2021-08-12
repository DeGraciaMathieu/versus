<?php

namespace App\Services;

use Exception;
use Illuminate\Config\Repository;

class LevelService
{
    protected Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function getLevelByElo(int $elo): Level
    {
        $levels = $this->getLevels();

        foreach ($levels as $level) {
            if (in_array($elo, $level->range, true)) {
                return $level;
            }
        }

        throw new Exception("Level not found by elo.");
    }

    protected function getLevels(): array
    {
        return array_map(function ($level) {
            return new Level($level);
        }, $this->config->get('level.levels'));
    }

    public function getNextLevel(Level $level): Level
    {
        $levels = $this->getLevels();

        $currentPosition = array_search($level, $levels);

        return $levels[++$currentPosition];
    }
}
