<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class FeedCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "feed", "Feed yourself", "/feed <player>", ["feed"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("feed.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			$sender->setFood(20);
			$sender->setSaturation(20);
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been fed");
			return false;
		}
		if(Main::getMainInstance()->getServer()->getPlayer($args[0])){
			$player = Main::getMainInstance()->getServer()->getPlayer($args[0]);
			$player->setFood(20);
			$player->setSaturation(20);
			$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been fed");
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have fed " . $player->getName());
		}
		return true;
	}
}