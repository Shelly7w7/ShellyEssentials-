<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class TpAllCommand extends BaseCommand{

	public function __construct(Main $main){
		parent::__construct($main, "tpall", "TP all players online", "/tpall", ["tpall"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("tpall.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		foreach(API::getMainInstance()->getServer()->getOnlinePlayers() as $player) $player->teleport($sender->asVector3());
		return true;
	}
}