<?php

namespace ArasakaID\Disguise\entity\types;

use pocketmine\entity\Location;
use pocketmine\entity\object\FallingBlock as PMFallingBlock;
use pocketmine\nbt\tag\CompoundTag;

class Block extends PMFallingBlock {

    public function __construct(Location $location, \pocketmine\block\Block $block, ?CompoundTag $nbt = null, private $blockSneak = false)
    {
        parent::__construct($location, $block, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if(($player = $this->getOwningEntity()) instanceof FakePlayer){
            if($this->blockSneak && $player->isSneaking()){
                $this->setPosition($player->getPosition()->add(0.5, 0, 0.5));
            } else {
                $this->setPosition($player->getPosition());
            }
            $player->setInvisible();
        }
        return true;
    }

    public function getName(): string
    {
        return "Block";
    }

}
