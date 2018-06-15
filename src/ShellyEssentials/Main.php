<?php

declare(strict_types=1);

namespace ShellyEssentials;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use ShellyEssentials\commands\AfkCommand;
use ShellyEssentials\commands\ClearInventoryCommand;
use ShellyEssentials\commands\FeedCommand;
use ShellyEssentials\commands\FlyCommand;
use ShellyEssentials\commands\FreezeCommand;
use ShellyEssentials\commands\GamemodeCreativeCommand;
use ShellyEssentials\commands\GamemodeSpectatorCommand;
use ShellyEssentials\commands\GamemodeSurvivalCommand;
use ShellyEssentials\commands\GodCommand;
use ShellyEssentials\commands\HealCommand;
use ShellyEssentials\commands\MuteCommand;
use ShellyEssentials\commands\NickCommand;
use ShellyEssentials\commands\SpawnCommand;
use ShellyEssentials\commands\VanishCommand;
use ShellyEssentials\commands\WildCommand;
use ShellyEssentials\commands\XYZCommand;
use ShellyEssentials\tasks\BroadcastTask;

class Main extends PluginBase{

	public const PREFIX = TextFormat::DARK_PURPLE . TextFormat::BOLD . "ShellyEssentials > " . TextFormat::RESET;

	/** @var self $instance */
	private static $instance;

	public function onEnable() : void{
		self::$instance = $this;
		API::setMotd(str_replace("&", "§", strval($this->getConfig()->get("motd"))));
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		$this->getServer()->getCommandMap()->registerAll("ShellyEssentials", [
			new ClearInventoryCommand($this),
			new FeedCommand($this),
			new FlyCommand($this),
			new FreezeCommand($this),
			new GamemodeCreativeCommand($this),
			new GamemodeSpectatorCommand($this),
			new GamemodeSurvivalCommand($this),
			new HealCommand($this),
			new MuteCommand($this),
			new WildCommand($this),
			new NickCommand($this),
			new VanishCommand($this),
			new SpawnCommand($this),
			new XYZCommand($this),
			new GodCommand($this),
			new AfkCommand($this)
		]);
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new BroadcastTask($this), intval($this->getConfig()->get("broadcast-interval")) * 20);
	}

	public static function getInstance() : self{
		return self::$instance;
	}
}