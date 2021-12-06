<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\DisguiseEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Skeleton extends DisguiseEntity{

    public function getName(): string
    {
        return "Skeleton";
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::SKELETON;
    }
}