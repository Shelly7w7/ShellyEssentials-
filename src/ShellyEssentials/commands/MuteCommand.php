<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class MuteCommand extends BaseCommand{

	/** @var array $initMute */
	public static $initMute = [];

	public function __construct(Main $main){
		parent::__construct($main, "mute", "Mute someone", "/mute <player>", ["mute"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("mute.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			$sender->sendMessage(Main::PREFIX . TextFormat::GRAY . "Usage: /mute <player>");
			return false;
		}
		if(API::getMainInstance()->getServer()->getPlayer($args[0])){
			$player = API::getMainInstance()->getServer()->getPlayer($args[0]);
			if(!in_array($player->getName(), self::$initMute)){
				self::$initMute[] = $player->getName();
				$player->sendMessage(Main::PREFIX . TextFormat::RED . "You have now been muted");
				$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have muted " . $player->getName());
			}elseif(in_array($player->getName(), self::$initMute)){
				unset(self::$initMute[array_search($player->getName(), self::$initMute)]);
				$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have now been unmuted");
				$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have unmuted " . $player->getName());
			}
		}
		return true;
	}
}