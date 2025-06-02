# Projet Web S2

[📄 COMPTE RENDU ](https://github.com/alex-paolo-CIR/projetwebs2/blob/main/compte_rendu_projet_WEB_S2_MSD.pdf)

[📄 Télécharger le fichier `projet25_dbmsd.sql`](https://github.com/alex-paolo-CIR/projetwebs2/blob/main/projet25_dbmsd.sql)

---

## 🔑 Connexion

L'application propose deux types de comptes : **Administrateur** et **Utilisateur Standard**. Voici comment vous connecter :

### 1. **Accéder à la page de connexion**
   - Ouvrez votre navigateur et rendez-vous sur la page d'accueil du projet.
   - Cliquez sur le bouton **"Connexion"** en haut a gauche dans le menu de navigation.

### 2. **Identifiants pour tester**

#### Compte Administrateur
- **Email** : `admin@msd.com`  
- **Mot de passe** : `admin123`  

En tant qu'administrateur, vous pouvez :
   - Gérer les produits (ajouter, modifier, supprimer).
   - Consulter les commandes des utilisateurs.
   - Accéder à des fonctionnalités supplémentaires d'administration.

#### Compte Utilisateur Standard
- **Email** : `user@msd.com`  
- **Mot de passe** : `user`  

En tant qu'utilisateur standard, vous pouvez :
   - Parcourir les produits.
   - Ajouter des produits au panier.
   - Passer des commandes.

---

## 🖥️ Fonctionnalités Principales

### 1. **Page d'accueil**
   - Présente les produits disponibles, triés par catégories (Vêtements, CD, Vinyles, Accessoires).

### 2. **Système d'authentification**
   - Inscription et connexion pour accéder aux fonctionnalités personnalisées.
   - Déconnexion sécurisée via le menu utilisateur.

### 3. **Gestion des Produits**
   - **Administrateur** : Ajout, modification et suppression de produits via un tableau de bord dédié.
   - **Utilisateur** : Consultation des produits avec affichage des détails (prix, description, images).

### 4. **Panier et Commandes**
   - Ajoutez des articles au panier.
   - Passez une commande et suivez son statut (en attente, expédiée, etc.).

### 5. **Contact**
   - Envoyez un message via le formulaire de contact pour toute question ou support.

### 6. **Discographie**
   - Explorez la collection d'albums avec leurs descriptions détaillées.

---

## 👩‍🏫 Guide pour Tester l'Application

1. **Connexion** :
   - Connectez-vous avec les identifiants fournis ci-dessus (Administrateur ou Utilisateur Standard).

2. **Tester les rôles** :
   - En tant qu'**Administrateur**, essayez d'ajouter un produit, de le modifier, ou de le supprimer.
   - En tant qu'**Utilisateur Standard**, ajoutez des articles au panier et passez une commande.

3. **Explorer les fonctionnalités** :
   - Parcourez les différentes sections (produits, discographie, contact).
   - Envoyez un message via le formulaire de contact et vérifiez la base de données pour les nouveaux messages reçus.

---

## 🛠️ Structure des Rôles

| **Rôle**           | **Accès**                                                                 |
|---------------------|---------------------------------------------------------------------------|
| **Administrateur**  | Gestion complète des produits, commandes, et accès à toutes les sections. |
| **Utilisateur**     | Consultation des produits, gestion du panier, et passage de commandes.   |
