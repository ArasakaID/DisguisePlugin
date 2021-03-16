<?php

namespace ArasakaID\Disguise\command;

use ArasakaID\Disguise\data\PlayerData;
use ArasakaID\Disguise\entity\FallingBlock;
use ArasakaID\Disguise\entity\ItemEntity;
use ArasakaID\Disguise\entity\types\Chicken;
use ArasakaID\Disguise\entity\types\Cow;
use ArasakaID\Disguise\entity\types\Creeper;
use ArasakaID\Disguise\entity\types\Pig;
use ArasakaID\Disguise\entity\Player as DisguisePlayer;
use ArasakaID\Disguise\entity\types\Sheep;
use ArasakaID\Disguise\entity\types\Skeleton;
use ArasakaID\Disguise\entity\types\Villager;
use ArasakaID\Disguise\entity\types\Wolf;
use ArasakaID\Disguise\entity\types\Zombie;
use ArasakaID\Disguise\Main;
use pocketmine\block\Block;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class DisguiseCommand extends Command
{

    private Main $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("disguise", "Disguised as whatever you want!");
        $this->plugin = $plugin;
        $this->setPermission("disguise.command.use");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($this->testPermission($sender)) {
            if ($sender instanceof Player) {
                $playerData = new PlayerData($sender);
                if ($playerData->isRegistered()) {
                    $playerData->resetEntity();
                }
                if (count($args) !== 0) {
                    switch ($args[0]) {
                        case "block":
                            if($sender->hasPermission("disguise.command.block")) {
                                if (isset($args[1])) {
                                    $itemFactory = ItemFactory::fromStringSingle($args[1]);
                                    if ($itemFactory instanceof ItemBlock) {
                                        $id = $itemFactory->getId();
                                        $meta = $args[2] ?? 0;
                                        $nbt = Entity::createBaseNBT($sender);
                                        $block = new Block($id, $meta);
                                        $nbt->setInt("TileID", $block->getId());
                                        $nbt->setByte("Data", $block->getDamage());
                                        $entity = new FallingBlock($sender->getLevel(), $nbt, $sender);
                                        $entity->spawnToAll();
                                        $playerData->setEntityId($entity->getId());
                                        $sender->sendMessage(str_replace('{BlockName}', $itemFactory->getName(), $this->plugin->getConfig()->get("disguise-as-block")));
                                    } else {
                                        $sender->sendMessage(TextFormat::RED . "Item must be a Item Block!");
                                    }
                                } else {
                                    $sender->sendMessage(TextFormat::RED . "Wrong with the commands!");
                                }
                            }
                            break;
                        case "item":
                            if($sender->hasPermission("disguise.command.use.item")) {
                                if (isset($args[1])) {
                                    $itemFactory = ItemFactory::fromStringSingle($args[1]);
                                    $id = $itemFactory->getId();
                                    $meta = $args[2] ?? 0;
                                    $item = new Item($id, $meta);
                                    $itemTag = $item->nbtSerialize();
                                    $itemTag->setName("Item");
                                    $nbt = Entity::createBaseNBT($sender, null, lcg_value() * 360, 0);
                                    $nbt->setShort("Health", 5);
                                    $nbt->setShort("PickupDelay", 10);
                                    $nbt->setTag($itemTag);
                                    $itemEntity = new ItemEntity($sender->getLevel(), $nbt, $sender);
                                    $itemEntity->spawnToAll();
                                    $playerData->setEntityId($itemEntity->getId());
                                    $sender->sendMessage(str_replace('{ItemName}', $itemFactory->getName(), $this->plugin->getConfig()->get("disguise-as-item")));
                                } else {
                                    $sender->sendMessage(TextFormat::RED . "Type id/name the item!");
                                }
                            }
                            break;
                        case "entity":
                            if($this->plugin->getConfig()->get("disguise-entity")) {
                                if (isset($args[1])) {
                                    switch ($args[1]) {
                                        case "chicken":
                                            if ($sender->hasPermission("disguise.command.use.chicken")) {
                                                $nbt = Entity::createBaseNBT($sender);
                                                $entity = new Chicken($sender->level, $nbt, $sender);
                                                $entity->spawnToAll();
                                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                                                $playerData->setEntityId($entity->getId());
                                            }
                                            break;
                                        case "cow":
                                            if ($sender->hasPermission("disguise.command.use.cow")) {
                                                $nbt = Entity::createBaseNBT($sender);
                                                $entity = new Cow($sender->level, $nbt, $sender);
                                                $entity->spawnToAll();
                                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                                                $playerData->setEntityId($entity->getId());
                                            }
                                            break;
                                        case "creeper":
                                            if ($sender->hasPermission("disguise.command.use.creeper")) {
                                                $nbt = Entity::createBaseNBT($sender);
                                                $entity = new Creeper($sender->level, $nbt, $sender);
                                                $entity->spawnToAll();
                                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                                                $playerData->setEntityId($entity->getId());
                                            }
                                            break;
                                        case "pig":
                                            if ($sender->hasPermission("disguise.command.use.pig")) {
                                                $nbt = Entity::createBaseNBT($sender);
                                                $entity = new Pig($sender->level, $nbt, $sender);
                                                $entity->spawnToAll();
                                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                                                $playerData->setEntityId($entity->getId());
                                            }
                                            break;
                                        case "sheep":
                                            if ($sender->hasPermission("disguise.command.use.sheep")) {
                                                $nbt = Entity::createBaseNBT($sender);
                                                $entity = new Sheep($sender->level, $nbt, $sender);
                                                $entity->spawnToAll();
                                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                                                $playerData->setEntityId($entity->getId());
                                            }
                                            break;
                                        case "skeleton":
                                            if ($sender->hasPermission("disguise.command.use.skeleton")) {
                                                $nbt = Entity::createBaseNBT($sender);
                                                $entity = new Skeleton($sender->level, $nbt, $sender);
                                                $entity->spawnToAll();
                                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                                                $playerData->setEntityId($entity->getId());
                                            }
                                            break;
                                        case "villager":
                                            if ($sender->hasPermission("disguise.command.use.villager")) {
                                                $nbt = Entity::createBaseNBT($sender);
                                                $entity = new Villager($sender->level, $nbt, $sender);
                                                $entity->spawnToAll();
                                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                                                $playerData->setEntityId($entity->getId());
                                            }
                                            break;
                                        case "wolf":
                                            if ($sender->hasPermission("disguise.command.use.wolf")) {
                                                $nbt = Entity::createBaseNBT($sender);
                                                $entity = new Wolf($sender->level, $nbt, $sender);
                                                $entity->spawnToAll();
                                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                                                $playerData->setEntityId($entity->getId());
                                            }
                                            break;
                                        case "zombie":
                                            if ($sender->hasPermission("disguise.command.use.zombie")) {
                                                $nbt = Entity::createBaseNBT($sender);
                                                $entity = new Zombie($sender->level, $nbt, $sender);
                                                $entity->spawnToAll();
                                                $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                                                $playerData->setEntityId($entity->getId());
                                            }
                                            break;
                                    }
                                } else {
                                    $sender->sendMessage(TextFormat::RED . "Wrong with the commands!");
                                }
                            } else {
                                $sender->sendMessage(TextFormat::RED . "Disguise entity is disable!");
                            }
                            break;
                        case "player":
                            if($sender->hasPermission("disguise.command.use.player")) {
                                if (isset($args[1])) {
                                    $target = $sender->getServer()->getPlayerExact($args[1]);
                                    if ($target instanceof Player) {
                                        $sender->setSkin($target->getSkin());
                                        $sender->sendSkin();
                                        $sender->setNameTag($target->getNameTag());
                                        $sender->sendMessage(str_replace('{TargetName}', $target->getName(), $this->plugin->getConfig()->get("disguise-as-player")));

                                        $nbt = Entity::createBaseNBT($sender);
                                        $nbt->setTag($target->namedtag->getCompoundTag("Skin"));
                                        $entity = new DisguisePlayer($target->getLevelNonNull(), $nbt, $sender);
                                        $entity->setNameTag($target->getNameTag());
                                        $entity->setInvisible();
                                        $entity->spawnToAll();
                                        $playerData->setEntityId($entity->getId(), $target);
                                    } else {
                                        $sender->sendMessage(TextFormat::RED . "The player is not online in this server!");
                                    }
                                }
                            }
                            break;
                    }
                } else {
                    $sender->sendMessage(TextFormat::RED . "Invalid usage!");
                }
            }
        }
    }

}