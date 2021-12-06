<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\DisguiseEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Chicken extends DisguiseEntity{

    public function getName(): string
    {
        return "Chicken";
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::CHICKEN;
    }
}
