<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;

class Sheep extends Entity{

    public const NETWORK_ID = self::SHEEP;

    public function getName(): string
    {
        return "Sheep";
    }

}
