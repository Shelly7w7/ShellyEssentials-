<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class WorldTPCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "worldtp", "Teleport to a specific world", "/worldtp <world>", ["worldtp"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("worldtp.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			$sender->sendMessage(Main::PREFIX . TextFormat::GRAY . "Usage: /worldtp <world>");
			return false;
		}
		if(file_exists(Main::getInstance()->getServer()->getDataPath() . "worlds/" . $args[0])){
			$sender->teleport(Main::getInstance()->getServer()->getLevelByName($args[0])->getSafeSpawn());
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been teleported to the world named $args[0]");
		}else{
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "World does not exist");
			return false;
		}
		return true;
	}
}