<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class HealCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "heal", "Heal yourself", "/heal <player>", ["heal"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("heal.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			$sender->setHealth(20);
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been healed");
			return false;
		}
		if(Main::getInstance()->getServer()->getPlayer($args[0])){
			$player = Main::getInstance()->getServer()->getPlayer($args[0]);
			$player->setHealth(20);
			$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been healed");
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have healed " . $player->getName());
		}
		return true;
	}
}