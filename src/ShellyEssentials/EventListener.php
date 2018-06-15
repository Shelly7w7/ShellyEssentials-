<?php

declare(strict_types=1);

namespace ShellyEssentials;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Player;
use ShellyEssentials\commands\FreezeCommand;
use ShellyEssentials\commands\MuteCommand;
use ShellyEssentials\commands\WildCommand;

class EventListener implements Listener{

	public function onMove(PlayerMoveEvent $event) : void{
		if(in_array($event->getPlayer()->getName(), FreezeCommand::$initFreeze)) $event->setCancelled(true);
	}

	public function onChat(PlayerChatEvent $event) : void{
		if(in_array($event->getPlayer()->getName(), MuteCommand::$initMute)) $event->setCancelled(true);
	}

	public function onEntityDamage(EntityDamageEvent $event) : void{
		$entity = $event->getEntity();
		if($entity instanceof Player){
			if(in_array($entity->getName(), WildCommand::$initWild)){
				if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
					$event->setCancelled(true);
					unset(WildCommand::$initWild[array_search($entity->getName(), WildCommand::$initWild)]);
				}
			}
		}
	}
}