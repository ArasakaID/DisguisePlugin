<?php

namespace ArasakaID\Disguise\event;

use ArasakaID\Disguise\DisguisePlugin;
use ArasakaID\Disguise\entity\types\Item;
use ArasakaID\Disguise\entity\types\FakePlayer;
use ArasakaID\Disguise\session\Session;
use pocketmine\event\entity\EntityItemPickupEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\math\Vector3;
use pocketmine\Player as PMPlayer;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class EventHandler implements Listener
{

    public function onInventoryPickupItem(EntityItemPickupEvent $event){
        $item = $event->getItem();
        if($item instanceof Item){
            $event->cancel();
        }
    }

    public function onPlayerChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        $session = Session::getOrCreate($player);
        if(($entity = $session->getEntity()) instanceof FakePlayer){
            $event->cancel();
            if(($target = $entity->getTargetEntity()) instanceof Player) {
                if ($target->isOnline()) {
                    $target->chat($event->getMessage());
                } else {
                    $player->sendMessage(TextFormat::RED . "The player you disguised has offline!");
                }
            }
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $session = Session::getOrCreate($player);
        $session->destroySession();
    }

}
