<?php

namespace ArasakaID\Disguise\entity;

use ArasakaID\Disguise\data\PlayerData;
use pocketmine\Player as PMPlayer;
use pocketmine\entity\Human;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;

class Player extends Human{

    /** @var PMPlayer */
    protected $player;

    public function __construct(Level $level, CompoundTag $nbt, PMPlayer $player)
    {
        $this->player = $player;
        parent::__construct($level, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if($this->player === null){
            if(!$this->isFlaggedForDespawn()) {
                $this->flagForDespawn();
            }
            return false;
        }
        $playerData = new PlayerData($this->player);
        if(!$playerData->isRegistered()){
            if(!$this->isFlaggedForDespawn()) {
                $this->flagForDespawn();
            }
            return false;
        }
        $this->setInvisible();
        return true;
    }

    public function getName(): string
    {
        return "Player";
    }
}
