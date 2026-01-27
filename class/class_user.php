<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class utilisateurs
{
    public $db;
    private $email_user;
    private $user_name;
    private $contact_user;
    private $adress_user;
    private $type_user;
    private $password_user;
    private $profile_user;
    private $etat_compte;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // les mutatteurs

    public function set_email($email_user)
    {
        $this->email_user = $email_user;
    }

    public function get_email()
    {
        return $this->email_user;
    }
    public function set_name($user_name)
    {
        $this->user_name = $user_name;
    }

    public function get_name()
    {
        return $this->user_name;
    }

    public function set_adress($adress_user)
    {
        $this->adress_user = $adress_user;
    }

    public function get_adress()
    {
        return $this->adress_user;
    }

    public function set_contact($contact_user)
    {
        $this->contact_user = $contact_user;
    }

    public function get_contact()
    {
        return $this->contact_user;
    }

    public function set_password($password_user)
    {
        $this->password_user = $password_user;
    }

    public function get_password()
    {
        return $this->password_user;
    }

    public function set_profil($profile_user)
    {
        $this->profile_user = $profile_user;
    }

    public function get_profil()
    {
        return $this->profile_user;
    }

    public function set_type($type_user)
    {
        $this->type_user = $type_user;
    }

    public function get_type()
    {
        return $this->type_user;
    }

    public function set_etat($etat_compte)
    {
        $this->etat_compte = $etat_compte;
    }

    public function get_etat()
    {
        return $this->etat_compte;
    }



    public function enregistrer_utilisateur()
    {
      // condition pour verifier si une image a été téléchargée
        $image_telecharger = null;
        if (isset($this->profile_user['name']) && $this->profile_user['name'] != '') {
            $chemin_acces_img = "../fichier_img/";
            // condition pour verifier sin mon  dossier existe sinon il le creer
            if (!is_dir($chemin_acces_img)) {
                mkdir($chemin_acces_img, 0755, true);
            }
            // les types de fichiers autorisés
            $type_autorise = ['jpg', 'jpeg', 'png', 'gif'];
            // ce pour requiperer l'extension du fichier
            $ftype_fichier = strtolower(pathinfo($this->profile_user['name'], PATHINFO_EXTENSION));
            // condition pour verifier le type de l'image si il est autorisé
            if (!in_array($ftype_fichier, $type_autorise)) {
                return "Type de fichier non autorisé. Seuls JPEG, PNG, JPG, GIF sont acceptés.";
            }
            // condition pour mesurer la taille de l'image
            if ($this->profile_user['size'] > 10 * 1024 * 1024) { // 10MB le 10 * 1024 * 1024 ce pour calculer en octet
                return "La taille du fichier dépasse 10MB.";
            }
            //le nom unique des images pour éviter les conflits
            $unique_nom_image = uniqid() . '.' . $ftype_fichier;
            // pour 
            $supprimer_fichier = $chemin_acces_img . $unique_nom_image;
            // le code pour telecharger le fichier image
            if (move_uploaded_file($this->profile_user['tmp_name'], $supprimer_fichier)) {
                $image_telecharger = $unique_nom_image;
            } else {
                return "Erreur lors du téléchargement de l'image.";
            }
        }
            $req1 = $this->db->prepare('SELECT * FROM t_utilisateur WHERE mail_user = ?');
            $req1->bind_param("s", $this->email_user);
            $req1->execute();
            $rep=$req1->get_result();
            if($rep->num_rows > 0){
                return "un utilisateur avec cette adresse existe déjà";
            }
            else{
                    $req1 = $this->db->prepare('INSERT INTO t_utilisateur(mail_user,user_name,type_compte,password_user,profil_user,etat_compte,adress_user,contact_user) VALUES(?,?,?,?,?,?,?,?)');
                    $req1->bind_param("ssssssss", $this->email_user, $this->user_name,$this->type_user,$this->password_user,$image_telecharger,$this->etat_compte,$this->adress_user,$this->contact_user);
                    if ($req1->execute()) {
                        return "compte crée avec succès";
                    } else {
                        return "Erreur lors de l'enregistrement du compte";
                    }
            }
       
    }

    // la fonction pour modifier utilisateur
    // $email_user: l'email actuel de l'utilisateur à modifier
    public function modifier_utilisateur($email_user)
    {       
        // condition pour verifier si une image a été téléchargée
        $image_telecharger = null;
        if (isset($this->profile_user['name']) && $this->profile_user['name'] != '') {
            $chemin_acces_img = "../fichier_img/";
            // condition pour verifier sin mon  dossier existe sinon il le creer
            if (!is_dir($chemin_acces_img)) {
                mkdir($chemin_acces_img, 0755, true);
            }
            // les types de fichiers autorisés
            $type_autorise = ['jpg', 'jpeg', 'png', 'gif'];
            // ce pour requiperer l'extension du fichier
            $ftype_fichier = strtolower(pathinfo($this->profile_user['name'], PATHINFO_EXTENSION));
            // condition pour verifier le type de l'image si il est autorisé
            if (!in_array($ftype_fichier, $type_autorise)) {
                return "Type de fichier non autorisé. Seuls JPEG, PNG, JPG, GIF sont acceptés.";
            }
            // condition pour mesurer la taille de l'image
            if ($this->profile_user['size'] > 10 * 1024 * 1024) { // 10MB le 10 * 1024 * 1024 ce pour calculer en octet
                return "La taille du fichier dépasse 10MB.";
            }
            //le nom unique des images pour éviter les conflits
            $unique_nom_image = uniqid() . '.' . $ftype_fichier;

            $supprimer_fichier = $chemin_acces_img . $unique_nom_image;
            // le code pour telecharger le fichier image
            if (move_uploaded_file($this->profile_user['tmp_name'], $supprimer_fichier)) {
                $image_telecharger = $unique_nom_image;
            } else {
                return "Erreur lors du téléchargement de l'image.";
            }
        }
            // Construire dynamiquement la requête UPDATE selon champs fournis
            $champs = [];
            $types = '';
            $valeurs = [];
            // champs modifiables
            $champs[] = 'user_name = ?'; $types .= 's'; $valeurs[] = $this->user_name;
            $champs[] = 'adress_user = ?'; $types .= 's'; $valeurs[] = $this->adress_user;
            $champs[] = 'contact_user = ?'; $types .= 's'; $valeurs[] = $this->contact_user;
            $champs[] = 'password_user = ?'; $types .= 's'; $valeurs[] = $this->password_user;
            $champs[] = 'type_compte = ?'; $types .= 's'; $valeurs[] = $this->type_user;
            // password si fourni (hash attendu)
            if (!empty($this->password_user)) {
                $champs[] = 'password_user = ?'; $types .= 's'; $valeurs[] = $this->password_user;
            }
            // profil si nouvelle image
            if ($image_telecharger !== null) {
                $champs[] = 'profil_user = ?'; $types .= 's'; $valeurs[] = $image_telecharger;
            }
            if (count($champs) === 0) {
                return "Aucun champ à modifier";
            }

            $sql = 'UPDATE t_utilisateur SET ' . implode(', ', $champs) . ' WHERE mail_user = ?';
            $types .= 's';
            $valeurs[] = $email_user;

            $req_modif = $this->db->prepare($sql);
            if ($req_modif === false) {
                return "Erreur préparation requête";
            }

            // bind_param dynamique nécessite références mysqli
            $bind_params = [];
            $bind_params[] = & $types;
            for ($i = 0; $i < count($valeurs); $i++) {
                $bind_params[] = & $valeurs[$i];
            }
            call_user_func_array([$req_modif, 'bind_param'], $bind_params);

            if ($req_modif->execute()) {
                return "Utilisateur modifié avec succès";
            } else {
                return "Erreur lors de la modification de l'utilisateur";
            }
       
    }

// fonction pour supprimer l'utilisateur
    public function supprimer_utilisateur($email_user)
    {
        try {
            $req1 = $this->db->prepare('DELETE FROM t_utilisateur WHERE mail_user = ?');
            $req1->bind_param("s", $email_user);
            if ($req1->execute()) {
                return "Utilisateur supprimé avec succès";
            } else {
                return "Erreur lors de la suppression de l'utilisateur";
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // fonction pour que l'utilisate sé connecter 
    public function login_user()
    {
       
        // s'assurer que l'email et le mot de passe sont fournis
        if (empty($this->email_user) || empty($this->password_user)) {
            return "Email ou mot de passe manquant.";
        }

        // 1) vérifier dans la table t_utilisateur
        $req = $this->db->prepare('SELECT mail_user, user_name, password_user, type_compte, etat_compte FROM t_utilisateur WHERE mail_user = ? LIMIT 1');
        $req->bind_param("s", $this->email_user);
        $req->execute();
        $res = $req->get_result();
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            if (!password_verify($this->password_user, $row['password_user'])) {
                return "Mot de passe incorrect.";
            }
            $_SESSION['session_email_user'] = $row['mail_user'];
            $_SESSION['session_nom_user'] = $row['user_name'];
            $_SESSION['session_type_user'] = $row['type_compte'];
            return "connexion reussie";
        }
        // 2) sinon vérifier dans la table t_admin
        $req2 = $this->db->prepare('SELECT mail_admin, user_name, password_admin FROM t_admin WHERE mail_admin = ? LIMIT 1');
        $req2->bind_param("s", $this->email_user);
        $req2->execute();
        $resul_2 = $req2->get_result();
        if ($resul_2 && $resul_2->num_rows > 0) {
            $row2 = $resul_2->fetch_assoc();
            if (!password_verify($this->password_user, $row2['password_admin'])) {
                return "Mot de passe incorrect.";
            }
            $_SESSION['session_email_admin'] = $row2['mail_admin'];
            $_SESSION['session_nom_admin'] = $row2['user_name'];
            return "connexion reussie";
        }

        return "Aucun utilisateur trouvé avec cet e-mail.";
    }

    // afficher la liste de tous les utilisateurs pour l'admin pour que l'admin active ou desactive un compte
    public function afficher_utilisateurs()
    {
        $req = $this->db->query('SELECT mail_user,user_name,type_compte,profil_user,etat_compte,adress_user,contact_user FROM t_utilisateur where type_compte="particulier" or type_compte="Entreprise"  ');
        $req->execute();
        $resultat = $req->get_result();
        if ($resultat) {
            return $resultat->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // afficher les produits liés à un utilisateur (par email)
    public function affi_utilisateur_avec_produits($email_user)
    {
        // 't_produits' est un alias pour la table t_produits. On sélectionne ici
        // explicitement les colonnes pour plus de clarté.
        $stmt = $this->db->prepare(
            'SELECT t_produits.id, t_produits.designation, t_produits.categorie, t_produits.mail_user, t_produits.description, t_produits.prix, t_produits.quantite, t_produits.image
             FROM t_produits  WHERE t_produits.mail_user = ?'
        );
        $stmt->bind_param("s", $email_user);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res) {
            return $res->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }


}


?>