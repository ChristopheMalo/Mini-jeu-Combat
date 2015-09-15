<?php
class PersonnagesManager {
    /*
     * Attributs
     */
    private $_bdd; // Instance de PDO
    
    
    /*
     * Méthode de construction
     */
    public function __construct($bdd) {
        $this->setDb($bdd);
    }
    
    
    /*
     * Méthodes Mutateurs (Setters) - Pour modifier la valeur des attributs
     */
    public function setDb(PDO $bdd) {
        $this->_bdd = $bdd;
    }
    
    
    /*
     * Methodes CRUD
     */
     
    /*  Methode d'insertion d'un personnage dans la BDD
     *  Pour éviter le message d'erreur Strict Standards: Only variables should be passed by reference
     *  il faut utiliser bindValue et non bind Param
     */
    public function addPersonnage(Personnage $perso) {
        // prepare INSERT request
        // Assign Value Personnage
        // execute request
    
        // hydrate personnage with id and degats - initial = 0
        
        // close request
    }
    
    // Methode de mise à jour / modification d'un personnage dans la BDD
    public function updatePersonnage(Personnage $perso) {
        // prepare UPDATE request
        // assign value to request
        // execute request
        
        // close request
    }
    
    // Methode de suppression d'un personnage dans la BDD
    public function deletePersonnage(Personnage $perso) {
        // execute DELETE request
    }
    
    //Methode de selection d'un personnage avec clause WHERE
    public function getPersonnage($id) {
        // if INT
        // execute SELECT request with WHERE clause
        // return a Personnage object
    
        // else NAME.
        // execute SELECT request with WHERE clause
        // return a Personnage object
    }
    
    
    /*
     * Methodes complémentaires
     */
    // Methode de selection de toute la liste des personnages
    public function getListPersonnages($nom) {
        // return list of personnages
        // result is an array of personnage (instance)
    }
    
    // Méthode pour compter le nombre de personnage
    public function countPersonnages() {
        // execute COUNT() request and RETURN result
    }
    
    // Méthode pour déterminer si un personnage exist
    public function ifPersonnageExist($info) {
        // if int
        // execute COUNT() request with WHERE clause
        // return a BOOL.
    
        // else value is name
        // execute COUNT() request with WHERE clause
        // return a BOOL.
    }
}