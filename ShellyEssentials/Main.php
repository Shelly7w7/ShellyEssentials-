<?php

namespace ShellyEssentials;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase{

    public function onEnable(){
	$this->getLogger()->Info("ShellyHeal has been has been enabled.");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){

            case "heal":
                if($sender instanceof Player){
			if($sender->hasPermission("shellyheal.command")){
				$sender->setHealth(20);
				$sender->addTitle("§cHealed");
				$sender->sendMessage("§l§5ShellyHeal > §r§cYou Have Been Healed!");
			}
			   
                }
            break;

            case "feed":
                if($sender instanceof Player){
			if($sender->hasPermission("shellyfeed.command")){
				$sender->setFood(20);
				$sender->addTitle("§cFeed");
				$sender->sendMessage("§l§5ShellyHeal > §r§cYou Have Been Fed!");
			}
			   
                }
            break;

        }
        return true;
    }

}
		
