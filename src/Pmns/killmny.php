<?php

namespace Pmns;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Event;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerDeathEvent as PD;
use pocketmine\event\entity\EntityDamageByEntityEvent as EDBE;

class killmny extends PluginBase implements Listener {
    
    public function onEnable() {
        $this->getServer->getPluginManager()->registerEvent($this, $this);
    }
    
    public function onDie(PD $e) {
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $p = $e->getPlayer();
        if($e->getPlayer()->getLastDamageCause() instanceof EDBE) {
            if($e->getPlayer()->getLastDamageCause()->getDamager() instanceof Player) {
                $killer = $p->getLastDamageCause()->getDamager();
                $mny = $eco->myMoney($p);
                if($mny < 5) {
                    //do Nothing
                    return false;
                }
                $amo = mt_rand(1, $mny);
                $eco->addMoney($killer, $amo);
                $eco->reduceMoney($p, $amo);
                $killer->sendTip("§e+".$amo." §amoney\n§afor killing §b".$p->getName());
            }
        }
    }
}
