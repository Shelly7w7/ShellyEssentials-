<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class WildCommand extends BaseCommand{

	/** @var array $initWild */
	public static $initWild = [];

	public function __construct(Main $main){
		parent::__construct($main, "wild", "Teleport to a random location", "/wild", ["wild"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("wild.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		$x = rand(1, 1500);
		$z = rand(1, 1500);
		$sender->teleport(new Position($x, 128, $z, $sender->getLevel()));
		$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been teleported to coords " . TextFormat::AQUA . "X: $x | Y: 128 | Z: $z" . TextFormat::GREEN . " in the wild!");
		self::$initWild[] = $sender->getName();
		return true;
	}
}