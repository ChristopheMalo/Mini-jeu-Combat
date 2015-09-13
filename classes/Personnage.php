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
    const DETECT_ME     = 1;
    const PERSO_DEAD    = 2;
    const PERSO_COUP    = 3;


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
    public function frapper(Personnage $persoAFrapper) {
        
    }
    
    // Methode de gestion de réception d'un coup, d'un dégat
    // Augmentation des dégats par 10 - à 100 de dégats ou plus le personnage est mort
    public function recevoirUnCoup($param) {
        
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