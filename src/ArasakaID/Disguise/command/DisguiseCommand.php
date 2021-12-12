<?php

namespace ArasakaID\Disguise\command;

use ArasakaID\Disguise\DisguisePlugin;
use ArasakaID\Disguise\entity\DisguiseEntity;
use ArasakaID\Disguise\entity\types\Block;
use ArasakaID\Disguise\entity\types\FakePlayer;
use ArasakaID\Disguise\entity\types\Item;
use ArasakaID\Disguise\session\Session;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\ItemBlock;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\item\LegacyStringToItemParserException;
use pocketmine\item\StringToItemParser;
use pocketmine\network\mcpe\protocol\SetActorLinkPacket;
use pocketmine\network\mcpe\protocol\types\entity\EntityLink;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

class DisguiseCommand extends Command implements PluginOwned
{

    public function __construct(private DisguisePlugin $plugin)
    {
        parent::__construct("disguise", "Disguised as whatever you want");
        $this->setPermission("disguise.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player && $this->testPermission($sender)) {
            if (isset($args[0])) {
                $session = Session::getOrCreate($sender);
                if (in_array($args[0], ["fakeplayer", "player"]) or isset(DisguiseEntity::ENTITIES[ucfirst($args[0])])) {
                    switch (strtolower($args[0])) {
                        case "fakeplayer":
                        case "player":
                            if ($sender->hasPermission("disguise.command.as.player")) {
                                if (isset($args[1])) {
                                    if (($target = $sender->getServer()->getPlayerByPrefix($args[1])) instanceof Player) {
                                        if($target->getName() !== $sender->getName()) {
                                            $entity = new FakePlayer($sender->getLocation(), $target->getSkin());
                                            $entity->setOwningEntity($sender);
                                            $entity->setTargetEntity($target);
                                            $entity->setCanSaveWithChunk(false);
                                            $entity->spawnToAll();
                                            $session->setEntity($entity);
                                            $sender->sendMessage(str_replace('{TargetName}', $target->getName(), $this->plugin->getConfig()->get("disguise-as-player")));
                                        } else {
                                            $sender->sendMessage("§cYou can't disguised as your self!");
                                        }
                                    } else {
                                        $sender->sendMessage("§cPlayer $args[1] is not online!");
                                    }
                                }
                            } else {
                                $sender->sendMessage("§cYou don't have permission to use this command!");
                            }
                            break;
                        case "block":
                            if ($sender->hasPermission("disguise.command.as.block")) {
                                if (isset($args[1])) {
                                    try {
                                        $item = StringToItemParser::getInstance()->parse($args[1]) ?? LegacyStringToItemParser::getInstance()->parse($args[1]);
                                    } catch (LegacyStringToItemParserException) {
                                        $sender->sendMessage("§cItem $args[1] is not found!");
                                        break;
                                    }
                                    if ($item instanceof ItemBlock) {
                                        $block = $item->getBlock();
                                        $entity = new Block($sender->getLocation(), $block);
                                        $entity->setOwningEntity($sender);
                                        $entity->setCanSaveWithChunk(false);
                                        $entity->spawnToAll();

                                        $pk = new SetActorLinkPacket();
                                        $pk->link = new EntityLink($sender->getId(), $entity->getId(), EntityLink::TYPE_RIDER, true, true);
                                        $sender->getServer()->broadcastPackets($entity->getViewers(), [$pk]);

                                        $session->setEntity($entity);
                                        $sender->sendMessage(str_replace('{BlockName}', $block->getName(), $this->plugin->getConfig()->get("disguise-as-block")));
                                    }
                                } else {
                                    $sender->sendMessage("§cPlease include the block id!");
                                }
                            } else {
                                $sender->sendMessage("§cYou don't have permission to use this command!");
                            }
                            break;
                        case "item":
                            if ($sender->hasPermission("disguise.command.as.item")) {
                                if (isset($args[1])) {
                                    try {
                                        $item = StringToItemParser::getInstance()->parse($args[1]) ?? LegacyStringToItemParser::getInstance()->parse($args[1]);
                                    } catch (LegacyStringToItemParserException) {
                                        $sender->sendMessage("§cItem $args[1] is not found!");
                                        break;
                                    }
                                    $entity = new Item($sender->getLocation(), $item);
                                    $entity->setOwningEntity($sender);
                                    $entity->setCanSaveWithChunk(false);
                                    $entity->spawnToAll();
                                    $session->setEntity($entity);
                                    $sender->sendMessage(str_replace('{ItemName}', $item->getName(), $this->plugin->getConfig()->get("disguise-as-item")));
                                } else {
                                    $sender->sendMessage("§cPlease include the item id!");
                                }
                            } else {
                                $sender->sendMessage("§cYou don't have permission to use this command!");
                            }
                            break;
                        default:
                            if ($sender->hasPermission("disguise.command.as." . strtolower($args[0]))) {
                                $className = DisguiseEntity::ENTITIES[ucfirst($args[0])];
                                $entity = new $className($sender->getLocation());
                                $entity->setOwningEntity($sender);
                                $entity->setCanSaveWithChunk(false);
                                $entity->spawnToAll();
                                $session->setEntity($entity);
                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                            } else {
                                $sender->sendMessage("§cYou don't have permission to use this command!");
                            }
                            break;
                    }
                } else {
                    $sender->sendMessage("§c$args[0] is not available!");
                }
            } else {
                $sender->sendMessage("§cUsage: /disguise <type> [id:meta]");
            }
        }
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->plugin;
    }
}