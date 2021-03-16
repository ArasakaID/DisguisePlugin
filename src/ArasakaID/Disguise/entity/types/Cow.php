<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;

class Cow extends Entity{

    public const NETWORK_ID = self::COW;

    public function getName(): string
    {
        return "Cow";
    }

}