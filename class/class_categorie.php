<?php 

class categorie
{
    private $categorie;
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function get_categorie()
    {
        return $this->categorie;
    }

    public function set_categorie($categorie)
    {
        $this->categorie = $categorie;
    }


    public function cree_categorie()
    {
        $req1 = $this->db->prepare('INSERT INTO t_categorie(categorie) VALUES(?)');
        $req1->bind_param("s", $this->categorie);
        if ($req1->execute()) {
            return "catégorie crée avec succès";
        } else {
            return "Erreur lors de création du categorie";
        }
           
    }

   

    // fonction pour supprimer une categorie
    public function supprimer_categorie($id_categorie)
    {
        try {
            $req1 = $this->db->prepare('DELETE FROM t_categorie WHERE id_categorie = ?');
            $req1->bind_param("s", $id_categorie);
            if ($req1->execute()) {
                return "categorie supprimé avec succès";
            } else {
                return "Erreur lors de la suppression d'une categorie";
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

// fonction pour afficher les admin
      public function afficher_categorie()
    {
        $req = $this->db->query('SELECT * FROM t_categorie ');
        $req->execute();
        $resultat = $req->get_result();
        if ($resultat) {
            return $resultat->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

}






?>