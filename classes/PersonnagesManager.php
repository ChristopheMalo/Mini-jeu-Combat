<?php
class PersonnagesManager {
    /*
     * Attributs
     */
    private $bdd; // Instance de PDO
    
    
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
        $this->bdd = $bdd;
    }
    
    
    /*
     * Methodes CRUD
     */
     
    /*  Methode d'insertion d'un personnage dans la BDD
     *  Pour éviter le message d'erreur Strict Standards: Only variables should be passed by reference
     *  il faut utiliser bindValue et non bind Param
     */
    public function addPersonnage(Personnage $perso) {
        $req = $this->bdd->prepare('INSERT INTO Personnages_v2
                                             SET nom    = :nom,
                                                 type   = :type
                                   ');          // prepare INSERT request
        $req->bindValue(':nom',     $perso->getNom(),   PDO::PARAM_STR);    // Assign Value Personnage
        $req->bindValue(':type',    $perso->getType(),  PDO::PARAM_STR);    // Assign Value Type
        $req->execute();                                                    // execute request
    
        // hydrate personnage with id and degats - initial = 0
        $perso->hydrate([
            'id'     => $this->bdd->lastInsertId(),
            'degats' => 0,
            'atout'  => 0
        ]);
        
        $req->closeCursor(); // close request
    }
    
    // Methode de mise à jour / modification d'un personnage dans la BDD
    public function updatePersonnage(Personnage $perso) {
        // prepare UPDATE request
        // assign value to request
        // execute request
        $req = $this->bdd->prepare('UPDATE Personnages_v2
                                        SET degats          = :degats,
                                            timeToBeAsleep  = :timeToBeAsleep,
                                            atout           = :atout
                                      WHERE id = :id
                                    ');
        
        $req->bindValue(':degats',          $perso->getDegats(),            PDO::PARAM_INT);
        $req->bindValue(':timeToBeAsleep',  $perso->getTimeToBeAsleep(),    PDO::PARAM_INT);
        $req->bindValue(':atout',           $perso->getAtout(),             PDO::PARAM_INT);
        $req->bindValue(':id',              $perso->getId(),                PDO::PARAM_INT);
        
        $req->execute();
        
        $req->closeCursor(); // close request
    }
    
    // Methode de suppression d'un personnage dans la BDD
    public function deletePersonnage(Personnage $perso) {
        $this->bdd->exec('DELETE FROM Personnages_v2
                                 WHERE id = ' . $perso->getId());// execute DELETE request
    }
    
    //Methode de selection d'un personnage avec clause WHERE
    public function getPersonnage($info) {
        // if INT
        // execute SELECT request with WHERE clause
        if (is_int($info)) {
            $req = $this->bdd->query('SELECT id, nom, degats, timeToBeAsleep, type, atout
                                         FROM Personnages_v2
                                        WHERE id = ' . $info);
            $datasOfPerso = $req->fetch(PDO::FETCH_ASSOC);
        }
    
        // else NAME.
        // execute SELECT request with WHERE clause
        else {
            $req = $this->bdd->prepare('SELECT id, nom, degats, timeToBeAsleep, type, atout
                                           FROM Personnages_v2
                                          WHERE nom = :nom');
            $req->execute([':nom' => $info]);
            
            $datasOfPerso = $req->fetch(PDO::FETCH_ASSOC);
        }
        
        switch ($datasOfPerso['type']) {
            case 'guerrier' : return new Guerrier($datasOfPerso);
            case 'magicien' : return new Magicien($datasOfPerso);
            default : return null;
        }
        
        $req->closeCursor(); // close request
    }
    
    
    /*
     * Methodes complémentaires
     */
    // Methode de selection de toute la liste des personnages
    public function getListPersonnages($nom) {
        // return list of personnages WHERE nom is different of $nom - <> or !=
        // result is an array of personnage (instance)
        $persos = [];
        
        $req = $this->bdd->prepare('SELECT id, nom, degats, timeToBeAsleep, type, atout
                                      FROM Personnages_v2
                                     WHERE nom <> :nom
                                     ORDER BY nom');
        $req->execute([':nom' => $nom]);
        
        while ($datas = $req->fetch(PDO::FETCH_ASSOC)) {
            switch ($datas['type']) {
                case 'guerrier' : $persos[] = new Guerrier($datas);
                    break;
                case 'magicien' : $persos[] = new Magicien($datas);
                    break;
            }
        }
        
        return $persos;
        
        $req->closeCursor(); // close request
    }
    
    // Méthode pour compter le nombre de personnage
    public function countPersonnages() {
        return $this->bdd->query('SELECT COUNT(*)
                                     FROM Personnages_v2')->fetchColumn();// execute COUNT() request and RETURN result
    }
    
    // Méthode pour déterminer si un personnage exist
    public function ifPersonnageExist($info) {
        // verif if personnage with int id $info exist
        // then execute COUNT() request with WHERE clause
        // return a BOOL.
        if (is_int($info)) {
            return (bool) $this->bdd->query('SELECT COUNT(*)
                                                FROM Personnages_v2
                                               WHERE id = ' . $info)->fetchColumn();
        }
        
        // Sinon verif if value is name and exists
        // execute COUNT() request with WHERE clause
        // return a BOOL.
        $req = $this->bdd->prepare('SELECT COUNT(*)
                                       FROM Personnages_v2
                                      WHERE nom = :nom');
        $req->execute([':nom' => $info]);
        return (bool) $req->fetchColumn();
        
        $req->closeCursor(); // Close request
    }
}