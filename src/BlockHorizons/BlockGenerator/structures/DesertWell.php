<?php

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\object\BasicGenerator;
use pocketmine\block\BlockIds;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class DesertWell extends BasicGenerator
{

    protected ChunkManager $level;
    protected Vector3 $position;

    public function generate(ChunkManager $level, Random $rand, Vector3 $position): bool
    {
        $this->level = $level;
        $this->position = $position;

        $x = $position->getX();
        $y = $position->getY();
        $z = $position->getZ();

        $this->fill(new Vector3(0, 0, 0), new Vector3(4, 2, 4), BlockIds::SANDSTONE);
        $this->fill(new Vector3(1, 2, 1), new Vector3(3, 2, 3), BlockIds::AIR);
        $level->setBlockIdAt($x + 2, $y +2, $z + 0, BlockIds::SANDSTONE_STAIRS);
        $level->setBlockIdAt($x + 0, $y + 2, $z + 2, BlockIds::SANDSTONE_STAIRS);
        $level->setBlockIdAt($x + 4, $y + 2, $z + 2, BlockIds::SANDSTONE_STAIRS);
        $level->setBlockIdAt($x + 2, $y + 2, $z + 4, BlockIds::SANDSTONE_STAIRS);
        $this->fill(new Vector3(2, 1, 1), new Vector3(2, 1, 3), BlockIds::STILL_WATER);
        $this->fill(new Vector3(1, 1, 2), new Vector3(3, 1, 2), BlockIds::STILL_WATER);

        $this->fill(new Vector3(1, 2, 1), new Vector3(1, 4, 1), BlockIds::SANDSTONE);
        $this->fill(new Vector3(1, 2, 3), new Vector3(1, 4, 3), BlockIds::SANDSTONE);
        $this->fill(new Vector3(3, 2, 1), new Vector3(3, 4, 1), BlockIds::SANDSTONE);
        $this->fill(new Vector3(3, 2, 3), new Vector3(3, 4, 3), BlockIds::SANDSTONE);

        $this->fill(new Vector3(1, 5, 1), new Vector3(3, 5, 3), BlockIds::SANDSTONE_STAIRS);
        $level->setBlockIdAt($x + 2, $y + 5, $z + 2, BlockIds::SANDSTONE);

        return true;
    }
    
    public function fill(Vector3 $pos1, Vector3 $pos2, int $block) {
        $pos1 = $pos1->add($this->position);
        $pos2 = $pos2->add($this->position);
        $minX = min($pos1->x, $pos2->x);
        $minY = min($pos1->y, $pos2->y);
        $minZ = min($pos1->z, $pos2->z);
        $maxX = max($pos1->x, $pos2->x);
        $maxY = max($pos1->y, $pos2->y);
        $maxZ = max($pos1->z, $pos2->z);
        for($x = $minX; $x <= $maxX; $x++) {
            for($y = $minY; $y <= $maxY; $y++) {
                for($z = $minZ; $z <= $maxZ; $z++) {
                    $this->level->setBlockIdAt($x, $y, $z, $block);
                }
            }
        }
    }

}
