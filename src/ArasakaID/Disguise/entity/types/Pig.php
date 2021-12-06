<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\DisguiseEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Pig extends DisguiseEntity{

    public function getName(): string
    {
        return "Pig";
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::PIG;
    }
}
