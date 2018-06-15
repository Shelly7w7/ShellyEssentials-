<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\API;
use ShellyEssentials\Main;

class GamemodeSpectatorCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "gmspc", "Gamemode spectator command", "/gmspc <player>", ["gmspc"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("gmspc.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			$sender->setGamemode(Player::SPECTATOR);
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have set your gamemode to spectator");
			return false;
		}
		if(API::getMainInstance()->getServer()->getPlayer($args[0])){
			$player = API::getMainInstance()->getServer()->getPlayer($args[0]);
			$player->setGamemode(Player::SPECTATOR);
			$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "Your gamemode has been set to spectator");
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have set " . $player->getName() . "'s gamemode to spectator");
		}
		return true;
	}
}