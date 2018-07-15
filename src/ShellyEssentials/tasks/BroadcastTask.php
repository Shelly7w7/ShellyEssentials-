<?php

declare(strict_types=1);

namespace ShellyEssentials\tasks;

use pocketmine\scheduler\Task;
use ShellyEssentials\API;
use ShellyEssentials\Main;

class BroadcastTask extends Task{

	public function onRun(int $tick) : void{
		$messages = API::getMainInstance()->getConfig()->get("messages");
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
			API::getMainInstance()->getServer()->getMaxPlayers(),
			count(API::getMainInstance()->getServer()->getOnlinePlayers()),
			API::getMainInstance()->getServer()->getTicksPerSecond(),
			API::getMainInstance()->getServer()->getMotd()
		), $message);
		$prefix = str_replace("&", "§", API::getMainInstance()->getConfig()->get("prefix"));
		API::getMainInstance()->getServer()->broadcastMessage($prefix . $message);
	}
}
