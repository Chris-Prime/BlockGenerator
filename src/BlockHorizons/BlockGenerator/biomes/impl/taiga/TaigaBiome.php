<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;


class TaigaBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

        $trees = new TreePopulator(\pocketmine\block\Wood::SPRUCE);
        $trees->setBaseAmount(5);
        $trees->setRandomAmount(3);
        $this->addPopulator($trees);

        $this->setBaseHeight(0.2);
        $this->setHeightVariation(0.2);
    }

    public function getName(): string
    {
        return "Taiga";
    }
}
