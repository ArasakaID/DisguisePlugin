<?php

namespace ArasakaID\Disguise\entity\types;

use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\entity\Human;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

class FakePlayer extends Human{

    public function __construct(Location $location, Skin $skin, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $skin, $nbt);
    }

    public function attack(EntityDamageEvent $source): void
    {
        if(($owner = $this->getTargetEntity()) instanceof Player){
            $owner->attack($source);
        }
        parent::attack($source);
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if(($player = $this->getOwningEntity()) instanceof Player){
            $this->setPositionAndRotation($player->location, $player->location->yaw, $player->location->pitch);
        } elseif(!$this->isFlaggedForDespawn()) {
            $this->flagForDespawn();
        }
        return true;
    }

    public function getName(): string
    {
        return "FakePlayer";
    }
}
