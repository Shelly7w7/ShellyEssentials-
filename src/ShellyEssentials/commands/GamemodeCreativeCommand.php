<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class GamemodeCreativeCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "gmc", "Gamemode creative command", "/gmc <player>", ["gmc"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("gmc.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			$sender->setGamemode(Player::CREATIVE);
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have set your gamemode to creative");
			return false;
		}
		if(Main::getInstance()->getServer()->getPlayer($args[0])){
			$player = Main::getInstance()->getServer()->getPlayer($args[0]);
			$player->setGamemode(Player::CREATIVE);
			$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "Your gamemode has been set to creative");
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have set " . $player->getName() . "'s gamemode to creative");
		}
		return true;
	}
}