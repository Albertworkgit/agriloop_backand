<?php 

class commande
{
    private $id_commande;
    private $id_produit;
    private $mail_client;
    private $quantite;
    private $date_jour;
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function get_idcommande()
    {
        return $this->id_commande;
    }
    public function set_idcommande($id_commande)
    {
        $this->id_commande = $id_commande;
    }
    public function get_idproduit()
    {
        return $this->id_produit;
    }
    public function set_idproduit($id_produit)
    {
        $this->id_produit = $id_produit;
    }

    public function get_mailclient()
    {
        return $this->mail_client;
    }
    public function set_mailclient($mail_client)
    {
        $this->mail_client = $mail_client;
    }

    public function get_quantite()
    {
        return $this->quantite;
    }
    public function set_quantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function get_datejour()
    {
        return $this->date_jour;
    }
    public function set_datejour($date_jour)
    {
        $this->date_jour = $date_jour;
    }


    public function passer_commande()
    {
        $req1 = $this->db->prepare('INSERT INTO t_commande(id_produit,mail_user,quantite,date_jour) VALUES(?,?,?,?)');
        $req1->bind_param("ssss", $this->id_produit,$this->mail_client,$this->quantite,$this->date_jour);
        if ($req1->execute()) {
            return "commande reussie avec ! ";
        } else {
            return "eurrer de passer la commande ! ";
        }
          
    }
    // fonction pour annuler une commande
    public function annuler_commande($id_commande)
    {
        try {
            $req1 = $this->db->prepare('DELETE FROM t_commande WHERE id_commande =?');
            $req1->bind_param("i", $id_commande);
            if ($req1->execute()) {
                return "commande Annuller avec succès";
            } else {
                return "Erreur lors de l'annulation de la commande";
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    
   // afficher les commande liés à un compte utilisateur (par email utilisateur)
    // qui as publier le produit commande ça peut etre un particulier ou une entreprise
    public function affi_commande_du_client($email_client)
    {
        $req1 = $this->db->prepare('SELECT t_commande.*, t_produits.* FROM t_commande JOIN t_produits ON t_commande.id_produit = t_produits.id WHERE t_commande.mail_user = ?');
        $req1->bind_param("s", $email_client);
        $req1->execute();
        $res = $req1->get_result();
        if ($res) {
            return $res->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // afficher les commande liés à un compte utilisateur (par email utilisateur)
    // qui as publier le produit commande ça peut etre un particulier ou une entreprise
    public function affi_commande_son_utilisateur($email_user)
    {
        $req1 = $this->db->prepare('SELECT t_commande.* , t_produits.* FROM t_commande JOIN t_produits ON t_commande.id_produit = t_produits.id WHERE t_produits.mail_user = ?');
        $req1->bind_param("s", $email_user);
        $req1->execute();
        $res = $req1->get_result();
        if ($res) {
            return $res->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

}






?>