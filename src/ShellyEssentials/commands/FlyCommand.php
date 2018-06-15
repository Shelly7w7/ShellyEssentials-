<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class FlyCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "fly", "Allow yourself to fly", "/fly <player>", ["fly"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("fly.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			if(!$sender->isCreative()){
				$sender->sendMessage($sender->getAllowFlight() === false ? Main::PREFIX . TextFormat::GREEN . "You have activated flight" : Main::PREFIX . TextFormat::RED . "You have disabled flight");
				$sender->setAllowFlight($sender->getAllowFlight() === false ? true : false);
			}else{
				$sender->sendMessage(Main::PREFIX . TextFormat::RED . "You can only use this command in survival mode");
				return false;
			}
			return false;
		}
		if(Main::getInstance()->getServer()->getPlayer($args[0])){
			$player = Main::getInstance()->getServer()->getPlayer($args[0]);
			if(!$player->isCreative()){
				$player->sendMessage($player->getAllowFlight() === false ? Main::PREFIX . TextFormat::GREEN . "You have activated flight" : Main::PREFIX . TextFormat::RED . "You have disabled flight");
				$sender->sendMessage($player->getAllowFlight() === false ? Main::PREFIX . TextFormat::GREEN . "You have enabled fly for " . $player->getName() : Main::PREFIX . TextFormat::RED . "You have disabled fly for " . $player->getName());
				$player->setAllowFlight($player->getAllowFlight() === false ? true : false);
			}else{
				$sender->sendMessage(Main::PREFIX . TextFormat::RED . $player->getName() . " is in creative mode");
				return false;
			}
		}
		return true;
	}
}