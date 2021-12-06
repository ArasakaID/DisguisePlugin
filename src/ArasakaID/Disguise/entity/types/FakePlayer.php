<?php

namespace ArasakaID\Disguise\entity\types;

use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\entity\Human;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

class FakePlayer extends Human{

    public function __construct(Location $location, Skin $skin, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $skin, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if(($player = $this->getOwningEntity()) instanceof Player){
            $this->setPositionAndRotation($player->location, $player->location->yaw, $player->location->pitch);
        }
        return true;
    }

    public function getName(): string
    {
        return "FakePlayer";
    }
}
