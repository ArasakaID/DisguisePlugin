<?php

namespace ArasakaID\Disguise;

use ArasakaID\Disguise\command\DisguiseCommand;
use ArasakaID\Disguise\entity\DisguiseEntity as DisguiseEntity;
use ArasakaID\Disguise\event\EventHandler;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class DisguisePlugin extends PluginBase
{
    use SingletonTrait;

    public function onLoad(): void
    {
        self::setInstance($this);
    }

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventHandler(), $this);
        $this->getServer()->getCommandMap()->register($this->getName(), new DisguiseCommand($this));

        DisguiseEntity::init();

        $this->checkConfig();
    }

    private function checkConfig()
    {
        if ($this->getConfig()->get("config-version") !== 1.2) {
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config-old.yml");
            $this->reloadConfig();
        }
    }

}