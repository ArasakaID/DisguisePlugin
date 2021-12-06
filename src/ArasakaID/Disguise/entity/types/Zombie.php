<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\DisguiseEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Zombie extends DisguiseEntity{

    public static function getNetworkTypeId(): string
    {
        return EntityIds::ZOMBIE;
    }

    public function getName(): string
    {
        return "Zombie";
    }

}
