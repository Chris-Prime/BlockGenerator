<?php


namespace BlockHorizons\BlockGenerator\populator;


use BlockHorizons\BlockGenerator\math\CustomRandom;
use BlockHorizons\BlockGenerator\structures\Dungeon;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\noise\Simplex;
use pocketmine\level\generator\populator\Populator;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class DungeonPopulator extends Populator
{

    protected Simplex $noise;

    public function __construct(CustomRandom $random) {
        $this->noise = new Simplex($random, 2, 1 / 4, 1 / 1024);
    }

    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random)
    {
        $density = $this->noise->getNoise2D($chunkX, $chunkZ);
        echo $density.PHP_EOL;
        // TODO
        if (false) {
            $x = ($chunkZ << 4) + $random->nextBoundedInt(16);
            $z = ($chunkZ << 4) + $random->nextBoundedInt(16);
            $y = $random->nextBoundedInt(256);

            $dungeon = new Dungeon($random);
            $dungeon->generate($level, $random, new Vector3($x, $y, $z));
        }
    }

}