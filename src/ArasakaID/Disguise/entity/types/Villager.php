<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;

class Villager extends Entity{

    public const NETWORK_ID = self::VILLAGER;

    public function getName(): string
    {
        return "Villager";
    }

}
