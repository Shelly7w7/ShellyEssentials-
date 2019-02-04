<?php

declare(strict_types=1);

namespace ShellyEssentials\tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use ShellyEssentials\API;

class JoinTitleTask extends Task{

	/** @var Player $player */
	private $player;

	public function __construct(Player $player){
		$this->player = $player;
	}

	public function onRun(int $tick) : void{
		$this->player->addTitle(str_replace("{playername}", $this->player->getName(), API::getMainInstance()->getConfig()->get("join-title")), str_replace("{playername}", $this->player->getName(), API::getMainInstance()->getConfig()->get("join-title")));
	}
}