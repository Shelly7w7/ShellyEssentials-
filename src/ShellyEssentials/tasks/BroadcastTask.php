<?php

declare(strict_types=1);

namespace ShellyEssentials\tasks;

use pocketmine\scheduler\Task;
use ShellyEssentials\Main;

class BroadcastTask extends Task{

	public function onRun(int $tick) : void{
		$messages = Main::getMainInstance()->getConfig()->get("messages");
		$message = $messages[array_rand($messages)];
		$message = str_replace([
			"&",
			"{line}",
			"{max_players}",
			"{online_players}",
			"{tps}",
			"{motd}"
		], [
			"§",
			"\n",
			Main::getMainInstance()->getServer()->getMaxPlayers(),
			count(Main::getMainInstance()->getServer()->getOnlinePlayers()),
			Main::getMainInstance()->getServer()->getTicksPerSecond(),
			Main::getMainInstance()->getServer()->getMotd()
		], $message);
		$prefix = str_replace("&", "§", Main::getMainInstance()->getConfig()->get("prefix"));
		Main::getMainInstance()->getServer()->broadcastMessage($prefix . $message);
	}
}