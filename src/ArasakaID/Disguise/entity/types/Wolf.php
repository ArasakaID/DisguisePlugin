<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\DisguiseEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Wolf extends DisguiseEntity{

    public function getName(): string
    {
        return "Wolf";
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::WOLF;
    }
}
