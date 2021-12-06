<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\DisguiseEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Creeper extends DisguiseEntity{

    public function getName(): string
    {
        return "Creeper";
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::CREEPER;
    }
}
