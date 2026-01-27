<?php
class produits
{
    public $db;
    private $id;
    private $designation;
    private $image_produit;
    private $email_user;
    private $description_produit;
    private $prix_produit;
    private $quantite_produit;
    private $categorie_produit;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // les mutatteurs
    public function set_designation($designation)
    {
        $this->designation = $designation;
    }

    public function get_designation()
    {
        return $this->designation;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_email_user($email_user)
    {
        $this->email_user = $email_user;
    }

    public function get_email_user()
    {
        return $this->email_user;
    }

    public function set_image($image_produit)
    {
        $this->image_produit = $image_produit;
    }

    public function get_image()
    {
        return $this->image_produit;
    }

    public function set_categorie($categorie_produit)
    {
        $this->categorie_produit = $categorie_produit;
    }

    public function get_categorie()
    {
        return $this->categorie_produit;
    }

    public function set_description($description_produit)
    {
        $this->description_produit = $description_produit;
    }

    public function get_description()
    {
        return $this->description_produit;
    }

    public function set_prix($prix_produit)
    {
        $this->prix_produit = $prix_produit;
    }
    public function get_prix()
    {
        return $this->prix_produit;
    }

    public function set_quantite($quantite_produit)
    {
        $this->quantite_produit = $quantite_produit;
    }
    public function get_quantite()
    {
        return $this->quantite_produit;
    }


   //CRUD Pour produit
    public function save_produit()
    {       
        // condition pour verifier si une image a été téléchargée
        $image_telecharger = null;
        if (isset($this->image_produit['name']) && $this->image_produit['name'] != '') {
            $chemin_acces_img = "../fichier_img/";
            // condition pour verifier sin mon  dossier existe sinon il le creer
            if (!is_dir($chemin_acces_img)) {
                mkdir($chemin_acces_img, 0755, true);
            }
            // les types de fichiers autorisés
            $type_autorise = ['jpg', 'jpeg', 'png', 'gif'];
            // ce pour requiperer l'extension du fichier
            $ftype_fichier = strtolower(pathinfo($this->image_produit['name'], PATHINFO_EXTENSION));
            // condition pour verifier le type de l'image si il est autorisé
            if (!in_array($ftype_fichier, $type_autorise)) {
                return "Type de fichier non autorisé. Seuls JPEG, PNG, JPG, GIF sont acceptés.";
            }
            // condition pour mesurer la taille de l'image
            if ($this->image_produit['size'] > 10 * 1024 * 1024) { // 10MB le 10 * 1024 * 1024 ce pour calculer en octet
                return "La taille du fichier dépasse 10MB.";
            }
            //le nom unique des images pour éviter les conflits
            $unique_nom_image = uniqid() . '.' . $ftype_fichier;
            // pour 
            $supprimer_fichier = $chemin_acces_img . $unique_nom_image;
            // le code pour telecharger le fichier image
            if (move_uploaded_file($this->image_produit['tmp_name'], $supprimer_fichier)) {
                $image_telecharger = $unique_nom_image;
            } else {
                return "Erreur lors du téléchargement de l'image.";
            }
        }
            $req1 = $this->db->prepare('INSERT INTO t_produits(designation,categorie,mail_user,description,prix,quantite,image) VALUES(?,?,?,?,?,?,?)');
            $req1->bind_param("sssssss", $this->designation, $this->categorie_produit, $this->email_user, $this->description_produit, $this->prix_produit, $this->quantite_produit, $image_telecharger);
            if ($req1->execute()) {
                return "Produit enregistré avec succès";
            } else {
                return "Erreur lors de l'enregistrement du produit";
            }
       
    }

    // fonction pour modifier produit 
     public function modifier_produit($id)
    {       
        // condition pour verifier si une image a été téléchargée
        $image_telecharger = null;
        if (isset($this->image_produit['name']) && $this->image_produit['name'] != '') {
            $chemin_acces_img = "../fichier_img/";
            // condition pour verifier sin mon  dossier existe sinon il le creer
            if (!is_dir($chemin_acces_img)) {
                mkdir($chemin_acces_img, 0755, true);
            }
            // les types de fichiers autorisés
            $type_autorise = ['jpg', 'jpeg', 'png', 'gif'];
            // ce pour requiperer l'extension du fichier
            $ftype_fichier = strtolower(pathinfo($this->image_produit['name'], PATHINFO_EXTENSION));
            // condition pour verifier le type de l'image si il est autorisé
            if (!in_array($ftype_fichier, $type_autorise)) {
                return "Type de fichier non autorisé. Seuls JPEG, PNG, JPG, GIF sont acceptés.";
            }
            // condition pour mesurer la taille de l'image
            if ($this->image_produit['size'] > 10 * 1024 * 1024) { // 10MB le 10 * 1024 * 1024 ce pour calculer en octet
                return "La taille du fichier dépasse 10MB.";
            }
            //le nom unique des images pour éviter les conflits
            $unique_nom_image = uniqid() . '.' . $ftype_fichier;

            $supprimer_fichier = $chemin_acces_img . $unique_nom_image;
            // le code pour telecharger le fichier image
            if (move_uploaded_file($this->image_produit['tmp_name'], $supprimer_fichier)) {
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
            $champs[] = 'designation = ?'; $types .= 's'; $valeurs[] = $this->designation;
            $champs[] = 'categorie = ?'; $types .= 's'; $valeurs[] = $this->categorie_produit;
            $champs[] = 'description = ?'; $types .= 's'; $valeurs[] = $this->description_produit;
            $champs[] = 'prix = ?'; $types .= 'd'; $valeurs[] = $this->prix_produit;
            $champs[] = 'quantite = ?'; $types .= 'd'; $valeurs[] = $this->quantite_produit;
            // profil si nouvelle image
            if ($image_telecharger !== null) {
                $champs[] = 'image = ?'; $types .= 's'; $valeurs[] = $image_telecharger;
            }
            if (count($champs) === 0) {
                return "Aucun champ à modifier";
            }
            $sql = 'UPDATE t_produits SET ' . implode(', ', $champs) . ' WHERE id = ?';
            $types .= 'i';
            $valeurs[] = $id;
            $req_modif = $this->db->prepare($sql);
            if ($req_modif === false) {
                return "Erreur préparation de la requête";
            }
            // bind_param dynamique nécessite références mysqli
            $bind_params = [];
            $bind_params[] = & $types;
            for ($i = 0; $i < count($valeurs); $i++) {
                $bind_params[] = & $valeurs[$i];
            }
            call_user_func_array([$req_modif, 'bind_param'], $bind_params);
            if ($req_modif->execute()) {
                return "produit modifié avec succès";
            } else {
                return "Erreur lors de la modification du produit";
            }       
    }

    public function supprimer_produit($id)
    {
        try {
            $req1 = $this->db->prepare('DELETE FROM  t_produits WHERE id=?');
            $req1->bind_param("i",$id);
            if ($req1->execute()) {
                return "Produit supprimer avec succès";
            } 
        } catch (Exception $e) {
            $e->getMessage();
        }
    }


    //  afficher tout les produit aux utilisateur client
    public function affi_produit()
    {
        $req = $this->db->prepare('SELECT * FROM t_produits');
        $req->bind_param();
        $req->execute();
        $res = $req->get_result();
        if ($res) {
            return $res->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

}
?>