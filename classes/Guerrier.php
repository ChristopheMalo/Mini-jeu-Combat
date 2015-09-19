<?php
class Guerrier extends Personnage {

    function recevoirUnCoup() {
        if ($this->degats >= 0 && $this->degats <= 25) {
            $this->atout = 4;
        } elseif ($this->degats > 25 && $this->degats <= 50) {
            $this->atout = 3;
        } elseif ($this->degats > 50 && $this->degats <= 75) {
            $this->atout = 2;
        } elseif ($this->degats > 75 && $this->degats <= 90) {
            $this->atout = 1;
        } else {
            $this->atout = 0;
        }
        
        // Augmentation des dégats par 5 - à 100 de dégats ou plus le personnage est mort
        $this->degats += 5 - $this->atout;
        
        // 100 ou plus de dégats => le personnage est tué
        if ($this->degats >= 100) {
            return self::PERSO_DEAD;
        }
        
        // Le personnage reçoit un coup
        return self::PERSO_COUP;
    }

}