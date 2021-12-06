<?php

namespace ArasakaID\Disguise\entity;

use ArasakaID\Disguise\entity\types\Chicken;
use ArasakaID\Disguise\entity\types\Cow;
use ArasakaID\Disguise\entity\types\Creeper;
use ArasakaID\Disguise\entity\types\Block;
use ArasakaID\Disguise\entity\types\FakePlayer;
use ArasakaID\Disguise\entity\types\Item;
use ArasakaID\Disguise\entity\types\Pig;
use ArasakaID\Disguise\entity\types\Sheep;
use ArasakaID\Disguise\entity\types\Skeleton;
use ArasakaID\Disguise\entity\types\Villager;
use ArasakaID\Disguise\entity\types\Wolf;
use ArasakaID\Disguise\entity\types\Zombie;
use pocketmine\block\BlockFactory;
use pocketmine\data\SavedDataLoadingException;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Human;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\world\World;

abstract class DisguiseEntity extends Entity {

    public const ENTITIES = [
        "Chicken" => Chicken::class,
        "Cow" => Cow::class,
        "Creeper" => Creeper::class,
        "Block" => Block::class,
        "Item" => Item::class,
        "Pig" => Pig::class,
        "FakePlayer" => FakePlayer::class,
        "Sheep" => Sheep::class,
        "Skeleton" => Skeleton::class,
        "Villager" => Villager::class,
        "Wolf" => Wolf::class,
        "Zombie" => Zombie::class
    ];

    public static function init(){
        foreach (self::ENTITIES as $name => $className){
            EntityFactory::getInstance()->register($className, function(World $world, CompoundTag $nbt) use ($className, $name) : Entity {
                switch ($name){
                    case "FakePlayer":
                        return new $className(EntityDataHelper::parseLocation($nbt, $world), Human::parseSkinNBT($nbt), $nbt);
                    case "Block":
                        return new $className(EntityDataHelper::parseLocation($nbt, $world), Block::parseBlockNBT(BlockFactory::getInstance(), $nbt), $nbt);
                    case "Item":
                        $itemTag = $nbt->getCompoundTag("Item");
                        if($itemTag === null){
                            throw new SavedDataLoadingException("Expected \"Item\" NBT tag not found");
                        }

                        $item = \pocketmine\item\Item::nbtDeserialize($itemTag);
                        if($item->isNull()){
                            throw new SavedDataLoadingException("Item is invalid");
                        }
                        return new $className(EntityDataHelper::parseLocation($nbt, $world), $item, $nbt);
                    default:
                        return new $className(EntityDataHelper::parseLocation($nbt, $world), $nbt);
                }
            }, [$name . "DisguiseEntity"]);
        }
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1.0, 1.0);
    }

    public function __construct(Location $location, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        $update = parent::entityBaseTick($tickDiff);
        if(($player = $this->getOwningEntity()) instanceof Player){
            $player->setInvisible();
            $location = $player->getLocation();
            $this->setPositionAndRotation($location, $location->yaw, $location->pitch);
        } elseif(!$this->isFlaggedForDespawn()) {
            $this->flagForDespawn();
        }
        return $update;
    }

}
