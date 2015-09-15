<?php
class Personnage {
    /*
     * Attributs
     */
    private $_id;
    private $_nom;
    private $_degats;
    
    
    /*
     * Déclaration des constantes
     */
    const DETECT_ME     = 1; // Constante renvoyée par la méthode frapperUnPersonnage - détecte si on se frappe soi-même
    const PERSO_DEAD    = 2; // Constante renvoyée par la méthode frapperUnPersonnage - détecte si un personnage est tué en le frappant
    const PERSO_COUP    = 3; // Constante renvoyée par la méthode frapperUnPersonnage - détecte si un coup est bien porté à un personnage


    /*
     * Méthode de construction
     */
    public function __construct(array $datas) {
        $this->hydrate($datas);
    }
    
    
    /*
     * Methode d'hydratation
     */
    public function hydrate(array $datas) {
        foreach ($datas as $key => $value) {
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
    
    
    /*
     * Méthodes génériques
     */
    // Methode de gestion de la frappe d'un personnage sur un autre
    public function frapperUnPersonnage(Personnage $persoAFrapper) {
        if ($persoAFrapper->getId() == $this->_id) {
            return self::DETECT_ME;
        }
        
        // Indication au personnage qu'il reçoit un coup / des dégats
        // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE
        return $persoAFrapper->recevoirUnCoup();
    }
    
    // Methode de gestion de réception d'un coup, d'un dégat
    // Augmentation des dégats par 10 - à 100 de dégats ou plus le personnage est mort
    public function recevoirUnCoup() {
        $this->_degats += 5;
        
        // 100 ou plus de dégats => le personnage est tué
        if ($this->_degats >= 100) {
            return self::PERSO_DEAD;
        }
        
        // Le personnage reçoit un coup
        return self::PERSO_COUP;
    }
    
    
    /*
     * Méthodes Accesseurs (Getters) - Pour récupérer / lire la valeur d'un attribut
     */
    public function getId() {
        return $this->_id;
    }
    
    public function getNom() {
        return $this->_nom;
    }
    
    public function getDegats() {
        return $this->_degats;
    }
    
    
     /*
      * Methodes Mutateurs (Setters) - Pour modifier la valeur d'un attribut
      */
     public function setId($id) {
         $this->_id = (int)$id; // Pas de vérification - ID est obligatoirement un entier strictement positif
     }
     
     public function setNom($nom) {
         if (is_string($nom)) {     // Vérification si présence d'une chaîne de caractères
             $this->_nom = $nom;    // On assigne alors la valeur $nom à l'attribut _nom
         }
     }
     
     public function setDegats($degats) {
         $degats = (int)$degats; // Conversion de l'argument en nombre entier
         // Vérification - Le nombre doit être strictemeznt positif et compris entre 0 et 100
         if ($degats >= 0 && $degats <= 100) {
             $this->_degats = $degats; // on assigne alors la valeur $degats à l'attribut _degats
         }
     }
    
}