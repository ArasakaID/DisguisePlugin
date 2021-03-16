<?php

namespace ArasakaID\Disguise;

use ArasakaID\Disguise\data\PlayerData;
use ArasakaID\Disguise\entity\FallingBlock;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\math\Vector3;
use pocketmine\Player as PMPlayer;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\TextFormat;

class EventListener implements Listener
{

    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onPlayerToggleSneak(PlayerToggleSneakEvent $event){
        $player = $event->getPlayer();
        $playerData = new PlayerData($player);
        if($this->plugin->getConfig()->get("disguise-block-sneak")) {
            if ($playerData->isRegistered()) {
                $entity = $playerData->getEntity();
                if ($entity instanceof FallingBlock) {
                    if($event->isSneaking()) {
                        $entity->teleport(new Vector3($player->getFloorX() + 0.5, $player->getFloorY() + 0.3, $player->getFloorZ() + 0.5));
                        $player->setImmobile();
                    } elseif($player->isImmobile()){
                        $player->setImmobile(false);
                    }

                }
            }
        }
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
