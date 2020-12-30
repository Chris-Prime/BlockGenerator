<?php


namespace BlockHorizons\BlockGenerator\structures;


use BlockHorizons\BlockGenerator\object\BasicGenerator;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\entity\EntityIds;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class Dungeon extends BasicGenerator
{

    const HEIGHT = 6;
    const MIN_RADIUS = 3;

    protected int $radiusX;
    protected int $radiusZ;
    protected int $sizeX;
    protected int $sizeZ;

    const MOB_TYPES = [
      EntityIds::SKELETON, EntityIds::ZOMBIE, EntityIds::ZOMBIE, EntityIds::SPIDER
    ];

    protected Random $random;

    public function __construct(Random $random) {
        $this->random = $random;

        //super(location, new Vector(9, HEIGHT, 9));
        // inner dungeon shape is 5x5, 5x7 or 7x7
        $this->radiusX = $this->random->nextBoundedInt(2) + self::MIN_RADIUS;
        $this->radiusZ = $this->random->nextBoundedInt(2) + self::MIN_RADIUS;
        $this->sizeX = ($this->radiusX << 1) + 1;
        $this->sizeZ = ($this->radiusZ << 1) + 1;
    }

    public function canBePlaced(int $x, int $y, int $z, ChunkManager $level): bool
    {
//        if($y < 50) {
//            return true;
//        }
        // TODO

        return false;
    }

    public function generate(ChunkManager $level, Random $rand, Vector3 $pos): bool
    {
        if (!$this->canBePlaced($pos->x, $pos->y, $pos->z, $level)) {
            return false;
        }

        for ($x = 0; $x < $this->sizeX; $x++) {
        for ($z = 0; $z < $this->sizeZ; $z++) {
            $xx = $pos->x + $x;
            $zz = $pos->z + $z;
            for ($y = self::HEIGHT - 1; $y >= 0; $y--) {
                $yy = $pos->y + $y;

                $state = Block::get($level->getBlockIdAt($xx, $yy, $zz));
                    if ($y > 0 && $x > 0 && $z > 0 && $x < $this->sizeX - 1 && $y < self::HEIGHT - 1
                        && $z < $this->sizeZ - 1) {
                        // empty space inside
                        $level->setBlockIdAt($xx, $yy, $zz, BlockIds::AIR);
                    } elseif (!$state->isSolid()) {
                        // cleaning walls from non solid materials (because of air gaps below)
                        $level->setBlockIdAt($xx, $yy, $zz, BlockIds::AIR);
                    } elseif ($state->isSolid()) {
                        // for walls we only replace solid material in order to
                        // preserve the air gaps
                        if ($y === 0) {
                            $level->setBlockIdAt($xx, $yy, $zz, mt_rand(1, 3) === 3 ? BlockIds::COBBLESTONE : BlockIds::MOSSY_COBBLESTONE);
                        } else {
                            $level->setBlockIdAt($xx, $yy, $zz, BlockIds::COBBLESTONE);
                        }
                    }
                }
            }
        }

        echo "dungeon generated: " . $pos->getFloorX() . "," . $pos->getFloorY() . "," . $pos->getFloorZ() . PHP_EOL;

        return true;
    }

}