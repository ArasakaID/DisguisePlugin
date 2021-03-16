<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;

class Zombie extends Entity{

    public const NETWORK_ID = self::ZOMBIE;

    public function getName(): string
    {
        return "Zombie";
    }

}
