<?php

namespace ArasakaID\Disguise\entity;

use ArasakaID\Disguise\data\PlayerData;
use pocketmine\entity\Entity as PMEntity;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

abstract class Entity extends PMEntity{

    protected ?Player $player = null;
    public $width = 1.3;
    public $height = 1.4;

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
        $this->setRotation($this->player->getYaw(), $this->player->getPitch());
        $this->player->setInvisible();
        return true;
    }

}
