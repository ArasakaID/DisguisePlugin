<?php

namespace ArasakaID\Disguise;

use ArasakaID\Disguise\command\DisguiseCommand;
use ArasakaID\Disguise\entity\DisguiseEntity as DisguiseEntity;
use ArasakaID\Disguise\event\EventHandler;
use pocketmine\plugin\PluginBase;

class DisguisePlugin extends PluginBase
{

    private static self $instance;

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function onLoad(): void
    {
        self::$instance = $this;
    }

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventHandler($this), $this);
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