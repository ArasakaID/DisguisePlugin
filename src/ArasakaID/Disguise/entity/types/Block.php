<?php

namespace ArasakaID\Disguise\entity\types;

use pocketmine\entity\Location;
use pocketmine\entity\object\FallingBlock;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\player\Player;

class Block extends FallingBlock {

    public function __construct(Location $location, \pocketmine\block\Block $block, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $block, $nbt);
    }

    public function initEntity(CompoundTag $nbt): void
    {
        parent::initEntity($nbt);
        $this->getNetworkProperties()->setVector3(EntityMetadataProperties::RIDER_SEAT_POSITION, new Vector3(0, -1.125, 0));
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if(($player = $this->getOwningEntity()) instanceof Player){
            $this->setPosition($player->getPosition()->add(0, -1.125, 0));
            $this->onGround = false;
            $player->setInvisible();
        } elseif(!$this->isFlaggedForDespawn()) {
            $this->flagForDespawn();
        }
        return parent::entityBaseTick();
    }

    public function getName(): string
    {
        return "Block";
    }

}
