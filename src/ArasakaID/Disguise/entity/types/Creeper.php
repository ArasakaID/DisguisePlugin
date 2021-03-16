<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;

class Creeper extends Entity{

    public const NETWORK_ID = self::CREEPER;

    public function getName(): string
    {
        return "Creeper";
    }

}
