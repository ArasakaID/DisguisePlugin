<?php

namespace ArasakaID\Disguise\data;

use pocketmine\entity\Entity as PMEntity;
use pocketmine\Player;

class PlayerData {

    private Player $player;
    private static array $entityId = [];
    private static array $fakePlayer = [];

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @param int $id
     * @param Player|null $target
     */
    public function setEntityId(int $id, ?Player $target = null){
        self::$entityId[$this->player->getName()] = $id;
        self::$fakePlayer[$this->player->getName()] = $target;
    }

    public function getFakePlayer(): ?Player{
        return self::$fakePlayer[$this->player->getName()] ?? null;
    }

    public function resetEntity(){
        $entity = $this->player->getLevel()->getEntity($this->getEntityId());
        if($entity !== null){
            if(!$entity->isFlaggedForDespawn()) {
                $entity->flagForDespawn();
            }
        }
        $this->player->setInvisible(false);
        unset(self::$entityId[$this->player->getName()]);
    }

    public function getEntityId(): int{
        return self::$entityId[$this->player->getName()];
    }

    public function getEntity(): PMEntity{
        return $this->player->getLevel()->getEntity($this->getEntityId());
    }

    public function isRegistered(): bool
    {
        if(isset(self::$entityId[$this->player->getName()])){
            return true;
        }
        return false;
    }

}
