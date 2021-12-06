<?php

namespace ArasakaID\Disguise\event;

use ArasakaID\Disguise\DisguisePlugin;
use ArasakaID\Disguise\entity\types\Block;
use ArasakaID\Disguise\entity\types\Item;
use ArasakaID\Disguise\entity\types\FakePlayer;
use ArasakaID\Disguise\session\Session;
use ArasakaID\Disguise\utils\Utils;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityItemPickupEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class EventHandler implements Listener
{

    private array $fakeBlockPosition = [];

    public function __construct(private DisguisePlugin $plugin)
    {
    }

    public function onInventoryPickupItem(EntityItemPickupEvent $event){
        $item = $event->getItem();
        if($item instanceof Item){
            $event->cancel();
        }
    }

    public function onBreakBlock(BlockBreakEvent $event){
        $block = $event->getBlock();
        if(isset($this->fakeBlockPosition[Utils::vectorToString($block->getPosition())])){
            unset($this->fakeBlockPosition[Utils::vectorToString($block->getPosition())]);
            $event->setDrops([]);
        }
    }

    public function onPlayerToggleSneak(PlayerToggleSneakEvent $event){
        $player = $event->getPlayer();
        $session = Session::getOrCreate($player);
        if(($entity = $session->getEntity()) instanceof Block && $this->plugin->getConfig()->get("disguise-block-sneak")){
            $pos = $player->getPosition();
            if($event->isSneaking()){
                if($player->getWorld()->getBlock($pos->down())->isSolid()) {
                    $player->getWorld()->setBlock($pos, $entity->getBlock());
                    $this->fakeBlockPosition[Utils::vectorToString($pos)] = $entity;
                    $player->teleport(new Vector3($pos->getFloorX() + 0.5, $pos->getFloorY(), $pos->getFloorZ() + 0.5));
                    $player->setImmobile();
                } else {
                    $player->sendMessage(TextFormat::RED . "You can't do that there!");
                }
            } else {
                if(isset($this->fakeBlockPosition[Utils::vectorToString($pos)])){
                    unset($this->fakeBlockPosition[Utils::vectorToString($pos)]);
                }
                $player->getWorld()->setBlock($pos, VanillaBlocks::AIR());
                $player->setImmobile(false);
            }
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
