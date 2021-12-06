<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\DisguiseEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Villager extends DisguiseEntity{

    public function getName(): string
    {
        return "Villager";
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::VILLAGER;
    }
}
