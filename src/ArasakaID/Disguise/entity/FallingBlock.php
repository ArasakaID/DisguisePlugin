<?php

namespace ArasakaID\Disguise\entity;

use ArasakaID\Disguise\data\PlayerData;
use pocketmine\entity\object\FallingBlock as PMFallingBlock;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class FallingBlock extends PMFallingBlock {

    protected ?Player $player = null;

    public function __construct(Level $level, CompoundTag $nbt, Player $player)
    {
        $this->player = $player;
        parent::__construct($level, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if($this->player === null){
            return false;
        }
        $playerData = new PlayerData($this->player);
        if(!$playerData->isRegistered()){
            return false;
        }
        $this->setPosition(new Vector3($this->player->getX(), $this->player->getY(), $this->player->getZ()));
        $this->player->setInvisible();
        return true;
    }

    public function getName(): string
    {
        return "FallingBlock";
    }

}
