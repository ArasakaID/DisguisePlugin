<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\DisguiseEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Cow extends DisguiseEntity{

    public function getName(): string
    {
        return "Cow";
    }
    public static function getNetworkTypeId(): string
    {
        return EntityIds::COW;
    }
}