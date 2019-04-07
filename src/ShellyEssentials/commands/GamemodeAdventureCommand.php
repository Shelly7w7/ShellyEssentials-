<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class GamemodeAdventureCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "gma", "Gamemode adventure command", "/gma <player>", ["gma"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("gma.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			$sender->setGamemode(Player::ADVENTURE);
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have set your gamemode to adventure");
			return false;
		}
		if(Main::getMainInstance()->getServer()->getPlayer($args[0])){
			$player = Main::getMainInstance()->getServer()->getPlayer($args[0]);
			$player->setGamemode(Player::ADVENTURE);
			$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "Your gamemode has been set to adventure");
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have set " . $player->getName() . "'s gamemode to adventure");
		}
		return true;
	}
}