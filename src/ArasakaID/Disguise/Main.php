<?php

namespace ArasakaID\Disguise;

use ArasakaID\Disguise\command\DisguiseCommand;
use ArasakaID\Disguise\entity\FallingBlock;
use ArasakaID\Disguise\entity\ItemEntity;
use ArasakaID\Disguise\entity\Player;
use ArasakaID\Disguise\entity\types\Chicken;
use ArasakaID\Disguise\entity\types\Cow;
use ArasakaID\Disguise\entity\types\Creeper;
use ArasakaID\Disguise\entity\types\Pig;
use ArasakaID\Disguise\entity\types\Sheep;
use ArasakaID\Disguise\entity\types\Skeleton;
use ArasakaID\Disguise\entity\types\Villager;
use ArasakaID\Disguise\entity\types\Wolf;
use ArasakaID\Disguise\entity\types\Zombie;
use ArasakaID\Disguise\entity\Entity as DisguiseEntity;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register($this->getName(), new DisguiseCommand($this));
        $this->registerEntities();
        $this->checkConfig();
    }

    private function registerEntities(){
        Entity::registerEntity(FallingBlock::class, true);
        Entity::registerEntity(ItemEntity::class, true);
        Entity::registerEntity(DisguiseEntity::class, true);
        Entity::registerEntity(Player::class, true);
        if ($this->getConfig()->get("disguise-entity")) {
            $this->getLogger()->notice("Disguise Entity is enable, registering new entities class!");
            Entity::registerEntity(Chicken::class, true);
            Entity::registerEntity(Cow::class, true);
            Entity::registerEntity(Creeper::class, true);
            Entity::registerEntity(Pig::class, true);
            Entity::registerEntity(Sheep::class, true);
            Entity::registerEntity(Skeleton::class, true);
            Entity::registerEntity(Villager::class, true);
            Entity::registerEntity(Wolf::class, true);
            Entity::registerEntity(Zombie::class, true);
        } else {
            $this->getLogger()->notice("Disguise Entity is disable!");
        }
    }

    private function checkConfig()
    {
        if ($this->getConfig()->get("config-version") !== 1.0) {
            $this->getLogger()->notice("Updating config.yml !");
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config.old.yml");
            $this->reloadConfig();
        }
    }

}