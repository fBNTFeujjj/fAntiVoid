<?php

namespace BNTFeujjj\fAntiVoid;

use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\event\entity\EntityDamageEvent;

class Base extends PluginBase implements Listener
{

        use SingletonTrait;
        public function onLoad(): void
        {
            self::setInstance($this);
        }
    protected function onEnable(): void
    {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onVoid(EntityDamageEvent $event) {
        $config = $this->getConfig();
        $player = $event->getEntity();
        if ($event->getCause() === EntityDamageEvent::CAUSE_VOID && $player instanceof Player) {
            if (in_array($player->getWorld()->getFolderName(), $config->get("worlds", []))) {
                $event->cancel();
                $player->teleport($player->getWorld()->getSpawnLocation());
                $player->sendTip($config->get("message"));
            }
        }
    }
}