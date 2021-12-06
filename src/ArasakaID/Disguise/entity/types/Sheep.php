<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\DisguiseEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Sheep extends DisguiseEntity{

    public function getName(): string
    {
        return "Sheep";
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::SHEEP;
    }
}
