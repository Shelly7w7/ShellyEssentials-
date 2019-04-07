<?php

declare(strict_types=1);

namespace ShellyEssentials\tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use ShellyEssentials\Main;

class JoinTitleTask extends Task{

	/** @var Player $player */
	protected $player;

	public function __construct(Player $player){
		$this->player = $player;
	}

	public function onRun(int $tick) : void{
		$this->player->addTitle(str_replace("{playername}", $this->player->getName(), Main::getMainInstance()->getConfig()->get("join-title")), str_replace("{playername}", $this->player->getName(), Main::getMainInstance()->getConfig()->get("join-title")));
	}
}