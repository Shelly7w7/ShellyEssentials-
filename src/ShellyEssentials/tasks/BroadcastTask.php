<?php

declare(strict_types=1);

namespace ShellyEssentials\tasks;

use pocketmine\scheduler\PluginTask;
use ShellyEssentials\Main;

class BroadcastTask extends PluginTask{

	public function onRun(int $tick) : void{
		$messages = Main::getInstance()->getConfig()->get("messages");
		$message = $messages[array_rand($messages)];
		$message = str_replace(array(
			"&",
			"{line}",
			"{max_players}",
			"{online_players}",
			"{tps}",
			"{motd}"
		), array(
			"§",
			"\n",
			Main::getInstance()->getServer()->getMaxPlayers(),
			count(Main::getInstance()->getServer()->getOnlinePlayers()),
			Main::getInstance()->getServer()->getTicksPerSecond(),
			Main::getInstance()->getServer()->getMotd()
		), $message);
		$prefix = str_replace("&", "§", Main::getInstance()->getConfig()->get("prefix"));
		Main::getInstance()->getServer()->broadcastMessage($prefix . $message);
	}
}