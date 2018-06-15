<?php

declare(strict_types=1);

namespace ShellyEssentials\tasks;

use pocketmine\Player;
use pocketmine\scheduler\PluginTask;
use ShellyEssentials\API;
use ShellyEssentials\Main;

class JoinTitleTask extends PluginTask{

	/** @var Player $player */
	private $player;

	public function __construct(Main $main, Player $player){
		$this->player = $player;
		parent::__construct($main);
	}

	public function onRun(int $tick) : void{
		$this->player->addTitle(strval(API::getMainInstance()->getConfig()->get("join-title")), strval(API::getMainInstance()->getConfig()->get("join-subtitle")));
	}
}