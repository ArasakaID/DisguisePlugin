<?php

namespace ArasakaID\Disguise\entity\types;

use pocketmine\entity\Location;
use pocketmine\entity\object\ItemEntity as PMItemEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

class Item extends PMItemEntity{

    public function __construct(Location $location, \pocketmine\item\Item $item, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $item, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if(($player = $this->getOwningEntity()) instanceof Player){
            $this->setPosition($player->getPosition());
            $player->setInvisible();
        }
        return true;
    }

    public function getName(): string
    {
        return "Item";
    }

}