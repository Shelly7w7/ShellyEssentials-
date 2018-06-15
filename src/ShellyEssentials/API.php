<?php

declare(strict_types=1);

namespace ShellyEssentials;

class API{

	public static function setMotd(string $motd) : void{
		Main::getInstance()->getServer()->getNetwork()->setName($motd);
	}
}