<?php
class Magicien extends Personnage {
    public function lancerUnSort(Personnage $persoAEnvouter) {
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
        
        if ($persoAEnvouter->id == $this->id) {
            return self::DETECT_ME;
        }
        
        if ($this->atout == 0) {
            return self::NO_MAGIE;
        }
        
        if ($this->toBeAsleep()) {
            return self::PERSO_ASLEEP;
        }
        
        $persoAEnvouter->timeToBeAsleep = time() + ($this->atout * 6) * 3600;
        
        return self::PERSO_ENVOUTE;
    }
}