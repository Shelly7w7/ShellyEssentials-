<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class SpawnCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "spawn", "Spawn command", "/spawn", ["spawn"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("spawn.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		$sender->teleport(Main::getMainInstance()->getServer()->getDefaultLevel()->getSafeSpawn());
		$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been teleported to spawn");
		return true;
	}
}