<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class FreezeCommand extends BaseCommand{

	/** @var array $initFreeze */
	public static $initFreeze = [];

	public function __construct(Main $main){
		parent::__construct($main, "freeze", "Freeze someone", "/freeze <player>", ["freeze"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("freeze.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			$sender->sendMessage(Main::PREFIX . TextFormat::GRAY . "Usage: /freeze <player>");
			return false;
		}
		if(API::getMainInstance()->getServer()->getPlayer($args[0])){
			$player = API::getMainInstance()->getServer()->getPlayer($args[0]);
			if(!in_array($player->getName(), self::$initFreeze)){
				self::$initFreeze[] = $player->getName();
				$player->sendMessage(Main::PREFIX . TextFormat::RED . "You have now been frozen");
				$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have froze " . $player->getName());
			}elseif(in_array($player->getName(), self::$initFreeze)){
				unset(self::$initFreeze[array_search($player->getName(), self::$initFreeze)]);
				$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have now been unfrozen");
				$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have unfroze " . $player->getName());
			}
		}
		return true;
	}
}