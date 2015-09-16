<?php
/*
 * Fonction d'autochargement de l'ensemble des classes du projet
 * 
 * La fonction charge toutes les classes nécessaire au projet
 * si les classses sont placées dans le dossier classes
 */
function chargerMesClasses($classes) {
    require 'classes/' . $classes . '.php';
}

spl_autoload_register('chargerMesClasses');

$db = new ConfigurationPDO(); // Utilisation d'une instance de la class PDO pour la connexion à la BDD
$bdd = $db->bdd();

$manager = new PersonnagesManager($bdd);

// Si souhait création personnage
if (isset($_POST['creer']) && isset($_POST['personnageNom']))
{
    $perso = new Personnage(['nom' => htmlspecialchars(strip_tags($_POST['personnageNom']))]); // Création du personnage

    if (!$perso->validName())
    {
        $message = 'Le nom choisi n\'est pas valide.';
        unset($perso);
    }
    elseif ($manager->ifPersonnageExist($perso->getNom()))
    {
        $message = 'Le nom du personnage est déjà utilisé.';
        unset($perso);
    }
    else
    {
        $manager->addPersonnage($perso);
        $message = 'Le personnage est créé.';
    }
}

elseif (isset($_POST['utiliser']) && isset($_POST['personnageNom'])) // Si souhait utilisation d'un personnage existant
    {
    if ($manager->ifPersonnageExist($_POST['personnageNom'])) // SI le personnage existe
    {
        $perso = $manager->getPersonnage($_POST['personnageNom']);
    }
    else
    {
        $message = 'Ce personnage n\'existe pas'; // Message si le personnage n'existe pas
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <meta name="description" content="Exemples POO en PHP - basé sur le MOOC POO - PHP OpenClassrooms">
        <meta name="keywords" content="POO, PHP, Bootstrap">
        <meta name="author" content="Christophe Malo">
            
        <title>Mini jeu de combat - POO - PHP</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css"  href="css/bootstrap_mini_jeu_combat_v01.css" media="all"> 
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
        <!-- Header
        ================================================== -->
            <header class="row col-sm-12">
                <h1>Mini jeu de combat - POO - PHP</h1>
            </header>
        
        <!-- Section Contenu
        ================================================== -->
            <section id="infos" class="row col-sm-12">
                <p>Nombre de personnage créés : <?= $manager->countPersonnages() ?></p>
                <p>
                    <?php
                        if (isset($message)) {  // Si message à afficher
                            echo $message;      // on affiche le message
                        }
                    ?>
                </p>
            </section>
        
        <!-- Section Personnage
        ================================================== -->
            <?php
            // Si utilisation d'un personnage
            if (isset($perso)) {
            ?>
                <section class="row col-sm-12">
                    <fieldset>
                        <legend>Mes informations</legend>
                        <p>
                            Nom : <?= htmlspecialchars($perso->getNom()); ?><br>
                            Dégâts : <?= $perso->getDegats(); ?>
                        </p>
                    </fieldset>
                    <fieldset>
                        <legend>Qui frapper ?</legend>
                        <p>
                        <?php
                            $persos = $manager->getListPersonnages($perso->getNom());
                            
                            if (empty($persos)) {
                                echo 'Il n\'y aucun adversaire';
                            } else {
                                foreach ($persos as $onePerson) {
                                    echo '<a href="?frapperUnPersonnage=' . $onePerson->getId() . '">' . htmlspecialchars($onePerson->getNom()) . '</a> (Dégats : ' . $onePerson->getDegats() .')<br>';
                                }
                            }
                        ?>
                        </p>
                    </fieldset>
                </section>
            
            <?php
            } else { // Si utilisation d'un personnage, formulaire n'est pas affiché
            ?>
        <!-- Section Formulaire saisie - choix
        ================================================== -->
                <section class="row col-sm-12">
                    <form class="form-horizontal" method="post">
                        <!-- Champ de saisie texte une ligne -->
                        <div class="form-group form-group-lg">
                            <label for="personnageNom" class="col xs-12 col-sm-4 col-md-3 control-label">Nom du personnage : </label>
                            <div class="col-xs-12 col-sm-8 col-md-9 focus"> 
                                <input class="form-control" type="text" name="personnageNom" id="prenom" placeholder="Nom du personnage" autofocus required />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-default btn-lg pull-right" value="Créer le personnage" name="creer">Créer le personnage</button>
                        <button type="submit" class="btn btn-default btn-lg pull-right" value="Utiliser le personnage" name="utiliser">Utiliser le personnage</button>
                    </form>
                </section>
        <?php
            }
        ?>
        <!-- Footer
        ================================================== -->
            <footer class="row col-sm-12">
                <p>Copyright 2015 Openclassrooms - Adaptation Christophe Malo</p> 
            </footer>
        </div>
    </body>
</html>
