<?php

declare(strict_types=1);

namespace ShellyEssentials\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;
use ShellyEssentials\Main;
use pocketmine\utils\TextFormat;

abstract class BaseCommand extends Command implements PluginIdentifiableCommand{

	public const NO_PERMISSION = Main::PREFIX . TextFormat::RED . "You do not have permission to use this command.";

	public function __construct(Main $main, string $name, string $description, string $usageMessage, array $aliases){
		parent::__construct($name, $description, $usageMessage, $aliases);
	}

	public function getPlugin() : Plugin{
		return API::getMainInstance();
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!API::getMainInstance()->isEnabled()) return false;
		if(!$this->testPermission($sender)) return false;
		$success = API::getMainInstance()->onCommand($sender, $this, $commandLabel, $args);
		if(!$success and $this->usageMessage !== "") throw new InvalidCommandSyntaxException();
		return $success;
	}
}