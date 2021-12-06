<?php

namespace ArasakaID\Disguise\session;

use ArasakaID\Disguise\DisguisePlugin;
use ArasakaID\Disguise\entity\types\Block;
use ArasakaID\Disguise\entity\types\Item;
use pocketmine\player\Player;
use ArasakaID\Disguise\entity\types\FakePlayer;

class Session {

    /** @var self[] */
    private static array $sessions = [];

    public static function getOrCreate(Player $player): self{
        return self::$sessions[$player->getName()] ?? self::$sessions[$player->getName()] = new self($player);
    }

    public function __construct(
        private Player $player,
        private DisguisePlugin|Block|Item|FakePlayer|null $entity = null
    ){}

    public function setEntity(Item|Block|DisguisePlugin|FakePlayer|null $entity): void
    {
        $this->despawnCurrentEntity();
        $this->entity = $entity;
    }

    public function getEntity(): Item|Block|DisguisePlugin|FakePlayer|null
    {
        return $this->entity;
    }

    public function despawnCurrentEntity(): void{
        if(($entity = $this->entity) !== null){
            $entity->close();
        }
    }

    public function destroySession(): void{
        $this->despawnCurrentEntity();
        unset(self::$sessions[$this->player->getName()]);
    }

}