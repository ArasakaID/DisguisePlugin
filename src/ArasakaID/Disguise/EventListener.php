<?php

namespace ArasakaID\Disguise;

use ArasakaID\Disguise\data\PlayerData;
use pocketmine\Player as PMPlayer;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\TextFormat;

class EventListener implements Listener
{

    private Main $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onPlayerChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        $playerData = new PlayerData($player);
        if($playerData->isRegistered()){
            $target = $playerData->getFakePlayer();
            if($target instanceof PMPlayer){
                $event->setCancelled();
                if($target->isOnline()) {
                    $target->chat($event->getMessage());
                } else {
                    $player->sendMessage(TextFormat::RED . "The player you disguised has offline!");
                }
            }
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $playerData = new PlayerData($player);
        if($playerData->isRegistered()){
            $playerData->resetEntity();
        }
    }

}
