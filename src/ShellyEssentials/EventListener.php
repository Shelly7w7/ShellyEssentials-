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
		if(in_array($player->getName(), FreezeCommand::$initFreeze)) $event->setCancelled(true);
		if(in_array($player->getName(), AfkCommand::$afk)){
			unset(AfkCommand::$afk[array_search($player->getName(), AfkCommand::$afk)]);
			$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You are no longer in afk mode");
			API::getMainInstance()->getServer()->broadcastMessage(TextFormat::YELLOW . $player->getName() . " is no longer AFK");
		}
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
			}elseif(in_array($entity->getName(), GodCommand::$god)){
				$event->setCancelled(true);
			}
			if($entity->getPosition()->getY() < 0){
				if(API::getMainInstance()->getConfig()->get("novoid") === "on"){
					$event->setCancelled(true);
					$entity->teleport(API::getMainInstance()->getServer()->getDefaultLevel()->getSafeSpawn());
					$entity->sendMessage(Main::PREFIX . TextFormat::GREEN . "You were teleported out of the void");
				}
			}
		}
	}

	public function onPlayerLogin(PlayerLoginEvent $event) : void{
		$event->getPlayer()->teleport(API::getMainInstance()->getServer()->getDefaultLevel()->getSafeSpawn());
	}

	public function onJoin(PlayerJoinEvent $event) : void{
		$player = $event->getPlayer();
		API::getMainInstance()->getScheduler()->scheduleDelayedTask(new JoinTitleTask($player), 30);
		$player->sendMessage(strval(API::getMainInstance()->getConfig()->get("join-message")));
	}

	public function onExhaust(PlayerExhaustEvent $event) : void{
		if(API::getMainInstance()->getConfig()->get("hunger-disabler") === "on") $event->setCancelled(true);
	}
}