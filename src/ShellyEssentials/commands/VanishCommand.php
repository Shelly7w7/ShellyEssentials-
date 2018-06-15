<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ShellyEssentials\Main;

class VanishCommand extends BaseCommand{

	/** @var array $vanish */
	private $vanish = [];

	public function __construct(Main $main){
		parent::__construct($main, "vanish", "Vanish yourself", "/vanish <player>", ["vanish"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$sender instanceof Player){
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Use this command in-game");
			return false;
		}
		if(!$sender->hasPermission("vanish.command")){
			$sender->sendMessage(self::NO_PERMISSION);
			return false;
		}
		if(empty($args[0])){
			if(!in_array($sender->getName(), $this->vanish)){
				$this->vanish[] = $sender->getName();
				$sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
				$sender->setNameTagVisible(false);
				$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been vanished");
			}elseif(in_array($sender->getName(), $this->vanish)){
				unset($this->vanish[array_search($sender->getName(), $this->vanish)]);
				$sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
				$sender->setNameTagVisible(true);
				$sender->sendMessage(Main::PREFIX . TextFormat::RED . "You have been unvanished");
			}
			return false;
		}
		if(Main::getInstance()->getServer()->getPlayer($args[0])){
			$player = Main::getInstance()->getServer()->getPlayer($args[0]);
			if(!in_array($player->getName(), $this->vanish)){
				$this->vanish[] = $player->getName();
				$player->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
				$player->setNameTagVisible(false);
				$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have been vanished");
				$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have vanished " . TextFormat::AQUA . $player->getName());
			}elseif(in_array($player->getName(), $this->vanish)){
				unset($this->vanish[array_search($player->getName(), $this->vanish)]);
				$player->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
				$player->setNameTagVisible(true);
				$player->sendMessage(Main::PREFIX . TextFormat::RED . "You have been unvanished");
				$sender->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have un-vanished " . TextFormat::AQUA . $player->getName());
			}
		}else{
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "Player not found");
			return false;
		}
		return true;
	}
}