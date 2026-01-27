<?php 

class admin
{
    private $nom_admin;
    private $mail_admin;
    private $password_admin;
    private $profil_admin;
    private $contact_admin;
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function get_profil()
    {
        return $this->profil_admin;
    }
    public function set_profil($profil_admin)
    {
        $this->profil_admin = $profil_admin;
    }
    public function get_mail()
    {
        return $this->mail_admin;
    }
    public function set_mail($mail_admin)
    {
        $this->mail_admin = $mail_admin;
    }

    public function get_contact()
    {
        return $this->contact_admin;
    }
    public function set_contact($contact_admin)
    {
        $this->contact_admin = $contact_admin;
    }

    public function get_password()
    {
        return $this->password_admin;
    }
    public function set_password($password_admin)
    {
        $this->password_admin = $password_admin;
    }

    public function get_nom()
    {
        return $this->nom_admin;
    }
    public function set_nom($nom_admin)
    {
        $this->nom_admin = $nom_admin;
    }

       public function cree_admin()
    {
      // condition pour verifier si une image a été téléchargée
        $image_telecharger = null;
        if (isset($this->profil_admin['name']) && $this->profil_admin['name'] != '') {
            $chemin_acces_img = "../fichier_img/";
            // condition pour verifier sin mon  dossier existe sinon il le creer
            if (!is_dir($chemin_acces_img)) {
                mkdir($chemin_acces_img, 0755, true);
            }
            // les types de fichiers autorisés
            $type_autorise = ['jpg', 'jpeg', 'png', 'gif'];
            // ce pour requiperer l'extension du fichier
            $ftype_fichier = strtolower(pathinfo($this->profil_admin['name'], PATHINFO_EXTENSION));
            // condition pour verifier le type de l'image si il est autorisé
            if (!in_array($ftype_fichier, $type_autorise)) {
                return "Type de fichier non autorisé. Seuls JPEG, PNG, JPG, GIF sont acceptés.";
            }
            // condition pour mesurer la taille de l'image
            if ($this->profil_admin['size'] > 10 * 1024 * 1024) { // 10MB le 10 * 1024 * 1024 ce pour calculer en octet
                return "La taille du fichier dépasse 10MB.";
            }
            //le nom unique des images pour éviter les conflits
            $unique_nom_image = uniqid() . '.' . $ftype_fichier;
            // pour 
            $supprimer_fichier = $chemin_acces_img . $unique_nom_image;
            // le code pour telecharger le fichier image
            if (move_uploaded_file($this->profil_admin['tmp_name'], $supprimer_fichier)) {
                $image_telecharger = $unique_nom_image;
            } else {
                return "Erreur lors du téléchargement de l'image.";
            }
        }
            $req1 = $this->db->prepare('SELECT * FROM t_admin WHERE mail_admin = ?');
            $req1->bind_param("s", $this->mail_admin);
            $req1->execute();
            $rep=$req1->get_result();
            if($rep->num_rows > 0){
                return "un utilisateur avec cette adresse existe déjà";
            }
            else{
                    $req1 = $this->db->prepare('INSERT INTO t_admin(mail_admin,password_admin,user_name,contact_admin,profil) VALUES(?,?,?,?,?)');
                    $req1->bind_param("sssss", $this->mail_admin,$this->password_admin,$this->nom_admin,$this->contact_admin,$image_telecharger);
                    if ($req1->execute()) {
                        return "compte Admin crée avec succès";
                    } else {
                        return "Erreur lors de la création du compte";
                    }
            }
       
    }

    public function modifier_admin($email_admin)
    {
        try {
             {       
        // condition pour verifier si une image a été téléchargée
        $image_telecharger = null;
        if (isset($this->profil_admin['name']) && $this->profil_admin['name'] != '') {
            $chemin_acces_img = "../fichier_img/";
            // condition pour verifier sin mon  dossier existe sinon il le creer
            if (!is_dir($chemin_acces_img)) {
                mkdir($chemin_acces_img, 0755, true);
            }
            // les types de fichiers autorisés
            $type_autorise = ['jpg', 'jpeg', 'png', 'gif'];
            // ce pour requiperer l'extension du fichier
            $ftype_fichier = strtolower(pathinfo($this->profil_admin['name'], PATHINFO_EXTENSION));
            // condition pour verifier le type de l'image si il est autorisé
            if (!in_array($ftype_fichier, $type_autorise)) {
                return "Type de fichier non autorisé. Seuls JPEG, PNG, JPG, GIF sont acceptés.";
            }
            // condition pour mesurer la taille de l'image
            if ($this->profil_admin['size'] > 10 * 1024 * 1024) { // 10MB le 10 * 1024 * 1024 ce pour calculer en octet
                return "La taille du fichier dépasse 10MB.";
            }
            //le nom unique des images pour éviter les conflits
            $unique_nom_image = uniqid() . '.' . $ftype_fichier;

            $supprimer_fichier = $chemin_acces_img . $unique_nom_image;
            // le code pour telecharger le fichier image
            if (move_uploaded_file($this->profil_admin['tmp_name'], $supprimer_fichier)) {
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
            $champs[] = 'password_admin = ?'; $types .= 's'; $valeurs[] = $this->password_admin;
            $champs[] = 'user_name = ?'; $types .= 's'; $valeurs[] = $this->nom_admin;
            $champs[] = 'contact_admin = ?'; $types .= 's'; $valeurs[] = $this->contact_admin;
            // password si fourni (hash attendu)
            if (!empty($this->password_admin)) {
                $champs[] = 'password_admin = ?'; $types .= 's'; $valeurs[] = $this->password_admin;
            }
            // profil si nouvelle image
            if ($image_telecharger !== null) {
                $champs[] = 'profil = ?'; $types .= 's'; $valeurs[] = $image_telecharger;
            }
            if (count($champs) === 0) {
                return "Aucun champ à modifier";
            }
            $sql = 'UPDATE t_admin SET ' . implode(', ', $champs) . ' WHERE mail_admin = ?';
            $types .= 's';
            $valeurs[] = $email_admin;

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
                return "Admin modifié avec succès";
            } else {
                return "Erreur lors de la modification de l'admin";
            }
       
    }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // fonction pour supprimer un admin
    public function supprimer_admin($email_admin)
    {
        try {
            $req1 = $this->db->prepare('DELETE FROM t_admin WHERE mail_admin = ?');
            $req1->bind_param("s", $email_admin);
            if ($req1->execute()) {
                return "admin supprimé avec succès";
            } else {
                return "Erreur lors de la suppression d'un admin";
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

// fonction pour afficher les admin
      public function afficher_admin()
    {
        $req = $this->db->query('SELECT * FROM t_admin ');
        $req->execute();
        $resultat = $req->get_result();
        if ($resultat) {
            return $resultat->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }




}






?>