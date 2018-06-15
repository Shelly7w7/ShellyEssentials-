<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class XYZCommand extends BaseCommand{

	/** @var array $xyz */
	private $xyz = [];

	public function __construct(Main $main){
		parent::__construct($main, "xyz", "Get your coords", "/xyz", ["xyz"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("xyz.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(!in_array($sender->getName(), $this->xyz)){
			$this->xyz[] = $sender->getName();
			$pk = new GameRulesChangedPacket();
			$pk->gameRules = ["showcoordinates" => [1, true]];
			$sender->dataPacket($pk);
			$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have turned on your coords");
		}elseif(in_array($sender->getName(), $this->xyz)){
			unset($this->xyz[array_search($sender->getName(), $this->xyz)]);
			$pk = new GameRulesChangedPacket();
			$pk->gameRules = ["showcoordinates" => [1, false]];
			$sender->dataPacket($pk);
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "You have turned off your coords");
		}
		return true;
	}
}