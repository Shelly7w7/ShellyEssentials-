<?php

declare(strict_types=1);

namespace ShellyEssentials;

class API{

	/** @var Main $instance */
	public static $instance;

	public static function getMainInstance() : Main{
		return self::$instance;
	}

	public static function setMotd(string $motd) : void{
		API::getMainInstance()->getServer()->getNetwork()->setName($motd);
	}
}