# DisguisePlugin

# Installation:
 1. Download the lastest plugin
 2. Put it to your server plugins folder
 3. Restart the server

# Permission:
| Disguise | Permission |
| --- | --- |
| Open Command | disguise.command.use |
| Item | disguise.command.use.item |
| Block | disguise.command.use.block |
| Player | disguise.command.use.player |
| Chicken | disguise.command.use.chicken |
| Cow | disguise.command.use.cow |
| Creeper | disguise.command.use.creeper |
| Pig | disguise.command.use.pig |
| Sheep | disguise.command.use.sheep |
| Skeleton | disguise.command.use.skeleton |
| Villager | disguise.command.use.villager |
| Wolf` | disguise.command.use.level |
| Zombie | disguise.command.use.zombie |

# Config:
```php
---
# Do not edit this!
config-version: 1.0

#Set true/false to enable/disable it
disguise-entity: true

#Messages
# You can colored the message with §
# {BlockName} is the block name
disguise-as-block: "You have disguised as {BlockName}"
# {ItemName} is the item name
disguise-as-item: "You have disguised as {ItemName}"
# {EntityName} is the block name
disguise-as-entity: "You have disguised as {EntityName}"
# {TargetName} is the player(target) name
disguise-as-player: "You have disguised as {TargetName}"
...
```
