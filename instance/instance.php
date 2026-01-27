<?php
session_start();
include_once("../bd/bd_con.php");
include_once("../class/class_produit.php");
include_once("../class/class_user.php");
include_once("../class/class_admin.php");
include_once("../class/class_commande.php");
include_once("../class/class_categorie.php");

$produit = new produits($db);
$utilisateur = new utilisateurs($db);
$admin = new admin($db);
$commande = new commande($db);
$categorie = new categorie($db);

// =========================CODE POUR ENREGISTRER=====================================
if(isset($_POST["save_user"]))
{
    $utilisateur->set_email($_POST["mail"]);
    $utilisateur->set_name($_POST["user_name"]);
    $utilisateur->set_type($_POST["type"]);
    $utilisateur->set_adress($_POST["adress"]);
    $utilisateur->set_profil($_FILES["profil"]);
    $utilisateur->set_password(password_hash($_POST["mdps"],PASSWORD_DEFAULT));
    $etat="desactive";
    $utilisateur->set_etat($etat);
    $utilisateur->set_contact($_POST["tel"]) ;
    $message = $utilisateur->enregistrer_utilisateur();
    $_SESSION['message'] = $message;
    header("location: ../form/save_user.php");
}

if(isset($_POST["save_produit"]))
{
    $produit->set_designation($_POST["designation"]);
    $produit->set_description($_POST["description"]);
    $produit->set_email_user($_POST["mail_user"]);
    $produit->set_image($_FILES["image"]);
    $produit->set_categorie($_POST["categorie"]) ;
    $produit->set_quantite($_POST["quantite"]) ;
    $produit->set_prix($_POST["prix"]) ;
    $message = $produit->save_produit();
    $_SESSION['message'] = $message;
    header("location: ../form/save_produit.php");
}
// cree un admin
if(isset($_POST["save_admin"]))
{
    $admin->set_nom($_POST["nom"]);
    $admin->set_mail($_POST["mail"]);
    $admin->set_password(password_hash($_POST["mdps"],PASSWORD_DEFAULT));
    $admin->set_profil($_FILES["profil"]);
    $admin->set_contact($_POST["tel"]) ;
    $message = $admin->cree_admin();
    $_SESSION['message'] = $message;
    header("location: ../form/save_admin.php");
}

// cree un admin
if(isset($_POST["save_commande"]))
{
    $date_jour=date("d/m/y");
    $commande->set_idproduit($_POST["id"]);
    $commande->set_mailclient($_POST["mail"]);
    $commande->set_quantite($_POST["quantite"]);
    $commande->set_datejour($date_jour);
    $message = $commande->passer_commande();
    $_SESSION['message'] = $message;
    header("location: ../form/save_commande.php");
}

// cree un categorie
if(isset($_POST["save_categorie"]))
{
    $categorie->set_categorie($_POST["categorie"]);
    $message = $categorie->cree_categorie();
    $_SESSION['message'] = $message;
    header("location: ../form/save_categorie.php");
}


// =========================CODE POUR L'AUTENTIFICATION DES UTILISATEUR SUR LE SYSTME=====================================
// Connexion utilisateur et les admin
if (isset($_POST['login'])) {
    $utilisateur->set_email($_POST['mail_user']);
    $utilisateur->set_password($_POST['mdps']); 
    $message = $utilisateur->login_user();
    $_SESSION['message'] = $message;
    header('Location: ../form/login.php');
    exit;
}

// =========================CODE POUR MODIFIER=====================================

// Modifier un admin
if (isset($_POST['modifier_admin'])) {
    $email_admin =$_POST['mail'] ?? null;
    // $email_user = (trim($_POST['mail'] ?? null)); //utiliser ceci si le mail vien du formulaire
    if (empty($email_admin)) {
        // je verifie si le mail existe sinon je redirige avec un message d'erreur
        $_SESSION['message'] = 'Email admin manquant pour la modification.';
        header('Location: ../form/modifier_admin.php');
        exit;
    }
    $admin->set_contact(trim($_POST['tel'] ?? ''));
    $admin->set_nom(trim($_POST['nom'] ?? ''));
    $admin->set_contact(trim($_POST['tel'] ?? ''));
    if (isset($_FILES['profil']) && isset($_FILES['profil']['error']) && $_FILES['profil']['error'] === 0) {
        $admin->set_profil($_FILES['profil']);
    }
    if (!empty($_POST['mdps'])) {
        $admin->set_password(password_hash($_POST['mdps'], PASSWORD_DEFAULT));
    }
    $message = $admin->modifier_admin($email_admin);
    $_SESSION['message'] = $message;
    header('Location: ../form/modifier_user.php');
    exit;
}

// Modifier un utilisateur
if (isset($_POST['modifier_user'])) {
    // identifier l'utilisateur à modifier champ 'mail' envoyé par le formulaire
    // mail du formulaire ou mail en session 
    $email_user =$_POST['mail'] ?? $_SESSION['session_email_user'] ?? null;
    // $email_user = (trim($_POST['mail'] ?? null)); //utiliser ceci si le mail vien du formulaire
    if (empty($email_user)) {
        // je verifie si le mail existe sinon je redirige avec un message d'erreur
        $_SESSION['message'] = 'Email utilisateur manquant pour la modification.';
        header('Location: ../form/modifier_user.php');
        exit;
    }
    // si post existe on l'utilise pour mettre à jour les champs si ils sont fournis 
    // ?? sinon on garde les valeurs actuelles de la base de données
    // la fonction trim() enlève les espaces au début et à la fin d’une chaîne
    $utilisateur->set_name(trim($_POST['user_name'] ?? ''));
    $utilisateur->set_type(trim($_POST['type'] ?? ''));
    $utilisateur->set_adress(trim($_POST['adress'] ?? ''));
    $utilisateur->set_contact(trim($_POST['tel'] ?? ''));
    // ne définir le profil que si un fichier a été uploadé sans erreur
    if (isset($_FILES['profil']) && isset($_FILES['profil']['error']) && $_FILES['profil']['error'] === 0) {
        $utilisateur->set_profil($_FILES['profil']);
    }
    // si un nouveau mot de passe est fourni, le hasher et le définir
    if (!empty($_POST['mdps'])) {
        $utilisateur->set_password(password_hash($_POST['mdps'], PASSWORD_DEFAULT));
    }
    $message = $utilisateur->modifier_utilisateur($email_user);
    $_SESSION['message'] = $message;
    header('Location: ../form/modifier_user.php');
    exit;
}

if (isset($_POST['modifier_produit'])) {
    // identifier l'utilisateur à modifier champ 'mail' envoyé par le formulaire
    // mail du formulaire ou mail en session 
    $id =$_POST['id'] ?? null;
    if (empty($id)) {
        // je verifie si le mail existe sinon je redirige avec un message d'erreur
        $_SESSION['message'] = 'Aucun produit est definie pour etre modifier.';
        header('Location: ../form/modifier_produit.php');
        exit;
    }
    $produit->set_designation(trim($_POST["designation"] ?? ''));
    $produit->set_description(trim($_POST["description"] ?? ''));
    // je dit de définir le profil que si un fichier a été uploadé sans erreur
    if (isset($_FILES['image']) && isset($_FILES['image']['error']) && $_FILES['image']['error'] === 0) {
        $produit->set_image($_FILES["image"]);
    }
    $produit->set_categorie(trim($_POST["categorie"] ?? ''));
    $produit->set_quantite($_POST["quantite"] ?? '');
    $produit->set_prix($_POST["prix"] ?? '') ;
    $message = $produit->modifier_produit($id);
    $_SESSION['message'] = $message;
    header('Location: ../form/modifier_user.php');
    exit;
}

// =========================CODE POUR SUPPRIMER=====================================


// supprimmer un utilisateur et produit
if (isset($_POST['supprimer_user'])) {
    $email_user = $_POST['mail'];
    $message = $utilisateur->supprimer_utilisateur($email_user);
    $_SESSION['message'] = $message;
    header('Location: ../form/supprimer_user.php');
    exit;
}
if (isset($_POST['supprimer_produit'])) {
    $id = $_POST['id'];
    $message = $produit->supprimer_produit($id);
    $_SESSION['message'] = $message;
    header('Location: ../form/supprimer_produit.php');
    exit;
}

// Supprimer un utilisateur 
if (isset($_POST['supprimer_admin'])) {
    $email_admin = $_POST['mail'];
    $message = $admin->supprimer_admin($email_admin);
    $_SESSION['message'] = $message;
    header('Location: ../form/supprimer_admin.php');
    exit;
}

// annuller la commande 
if (isset($_POST['annuller_commande'])) {
    $id_commande=$_POST['id'];
    $message = $commande->annuler_commande($id_commande);
    $_SESSION['message'] = $message;
    header('Location: ../form/annuller_commande.php');
    exit;
}

// supprimer commande 
if (isset($_GET['sup_commande'])) {
    $id_categorie=$_POST['id'];
    $message = $categorie->supprimer_categorie($id_categorie);
    $_SESSION['message'] = $message;
    header('Location: ../form/annuller_commande.php');
    exit;
}

//===============================MES EXEMPLE POUR APPELER LES CODE POUR SELECT =================================================================
// --============lLES AUTRE CODES DE SELECTION SONT DANS LES CLASS=================





//  afficher les commande liés à un compte utilisateur (par email utilisateur)
// qui as publier le produit commande ça peut etre un particulier ou une entreprise
if(isset($_POST['affi_commande_son_utilisateur'])) {
    // Appelez la fonction avec l'email de l'utilisateur
    $email_user = 'a@gmail.com';  // Remplacez par l'email réel
    $resultats = $commande->affi_commande_son_utilisateur($email_user);
    // Affichez ou traitez les résultats tableau associatif des commandes avec détails produits
    if (!empty($resultats)) {
        foreach ($resultats as $commande) {
            echo "ID Commande: " . $commande['id_commande'] . "<br>";
            echo "Produit: " . $commande['designation'] . "<br>";  // Adaptez selon les colonnes de t_produit
        
        }
    } else {
        echo "Aucune commande trouvée.";
    }
}


// afficher les commande lie à un client (par email client)
if(isset($_POST['affi_commande_du_client'])) {
    $email_client = 'albert@gmail.com';  // Utilisez l'email de la session
    $resultats = $commande->affi_commande_du_client($email_client);
    // Affichez ou traitez les résultats (tableau associatif des commandes avec détails produits)
    if (!empty($resultats)) {
        foreach ($resultats as $commande_res) {
            echo "ID Commande: " . $commande_res['id_commande'] . "<br>";
            echo "ID Produit: " . $commande_res['id_produit'] . "<br>";
            echo "Quantité: " . $commande_res['quantite'] . "<br>";
            echo "Date: " . $commande_res['date_jour'] . "<br>";
            echo "Désignation Produit: " . $commande_res['designation'] . "<br>";  // Adaptez selon les colonnes de t_produits
            // Ajoutez d'autres champs si nécessaire
        }
    } else {
        echo "Aucune commande trouvée pour ce client.";
    }
}

// afficher les commande lie à un client (par email client)
if(isset($_POST['affi_tout_produit'])) {
    $resultats = $produit->affi_produit();
    // Affichez ou traitez les résultats (tableau associatif des commandes avec détails produits)
    if (!empty($resultats)) {
        foreach ($resultats as $produit_res) {
            echo "Designation: " . $produit_res['designation'] . "<br>";
            echo "description: " . $produit_res['description'] . "<br>";
            echo "Categorie: " . $produit_res['categorie'] . "<br>";
            echo "Prix: " . $produit_res['prix'] . "<br>";
            echo "Prix: " . $produit_res['image'] . "<br>";
        }
    } else {
        echo "Aucune produit n'est disponible.";
    }
}

// afficher les categorie
if(isset($_POST['affi_categorie'])) {
    $resultats = $categorie->afficher_categorie();
    // Affichez ou traitez les résultats (tableau associatif des commandes avec détails produits)
    if (!empty($resultats)) {
        foreach ($resultats as $categorie_res) {
            echo "Categorie: " . $categorie_res['categorie'] . "<br>";
            // Ajoutez d'autres champs si nécessaire
        }
    } else {
        echo "Aucune categorie retrouver.";
    }
}
?>