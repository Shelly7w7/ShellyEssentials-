<?php

declare(strict_types=1);

namespace ShellyEssentials;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\commands\AfkCommand;
use ShellyEssentials\commands\FreezeCommand;
use ShellyEssentials\commands\GodCommand;
use ShellyEssentials\commands\MuteCommand;
use ShellyEssentials\commands\WildCommand;
use ShellyEssentials\tasks\JoinTitleTask;

class EventListener implements Listener{

	public function onMove(PlayerMoveEvent $event) : void{
		$player = $event->getPlayer();
		if(isset(FreezeCommand::$initFreeze[$player->getName()])) $event->setCancelled(true);
		if(isset(AfkCommand::$afk[$player->getName()])){
			unset(AfkCommand::$afk[$player->getName()]);
			$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You are no longer in afk mode");
			Main::getMainInstance()->getServer()->broadcastMessage(TextFormat::YELLOW . $player->getName() . " is no longer AFK");
		}
	}

	public function onChat(PlayerChatEvent $event) : void{
		if(isset(MuteCommand::$initMute[$event->getPlayer()->getName()])) $event->setCancelled(true);
	}

	public function onEntityDamage(EntityDamageEvent $event) : void{
		$entity = $event->getEntity();
		if($entity instanceof Player){
			if(isset(WildCommand::$initWild[$entity->getName()])){
				if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
					$event->setCancelled(true);
					unset(WildCommand::$initWild[$entity->getName()]);
				}
			}elseif(isset(GodCommand::$god[$entity->getName()])){
				$event->setCancelled(true);
			}
			if($entity->getPosition()->getY() < 0){
				if(Main::getMainInstance()->getConfig()->get("novoid") === "on"){
					$event->setCancelled(true);
					$entity->teleport(Main::getMainInstance()->getServer()->getDefaultLevel()->getSafeSpawn());
					$entity->sendMessage(Main::PREFIX . TextFormat::GREEN . "You were teleported out of the void");
				}
			}
		}
	}

	public function onPlayerLogin(PlayerLoginEvent $event) : void{
		if(Main::getMainInstance()->getConfig()->get("spawn-hub") === "on"){
			$event->getPlayer()->teleport(Main::getMainInstance()->getServer()->getDefaultLevel()->getSafeSpawn());
		}
	}

	public function onJoin(PlayerJoinEvent $event) : void{
		Main::getMainInstance()->getScheduler()->scheduleDelayedTask(new JoinTitleTask($event->getPlayer()), 30);
		$event->getPlayer()->sendMessage(strval(Main::getMainInstance()->getConfig()->get("join-message")));
	}

	public function onExhaust(PlayerExhaustEvent $event) : void{
		if(Main::getMainInstance()->getConfig()->get("hunger-disabler") === "on") $event->setCancelled(true);
	}
}