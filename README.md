# 🛒 Projet E-commerce **LapCom**

![E-Commerce](https://img.shields.io/badge/E--Commerce-LapCom-blue?style=for-the-badge&logo=shopify)
![Symfony](https://img.shields.io/badge/Powered_by-Symfony-brightgreen?style=for-the-badge&logo=symfony)
![License](https://img.shields.io/badge/License-MIT-yellow?style=for-the-badge&logo=license)
![Version](https://img.shields.io/badge/Version-1.0-lightgrey?style=for-the-badge&logo=github)

---

## 🎥 **Démonstration**
Cliquez ici pour visionner la vidéo de démonstration de mon projet **LAPCOM** :  
👉 [Visionner la vidéo](https://akamidev.github.io/LAPCOM/)

---

## 🌟 **Présentation du Projet**
Ce projet représente le point culminant de mon parcours académique en **Développement Web et Web Mobile (DWWM)**.  
J'ai conçu et développé un site e-commerce innovant pour **LapCom**, spécialisé dans la vente de matériel informatique. Ce projet vise à transformer **LapCom** en un acteur majeur du marché en ligne.

---

## 💡 **Introduction**
**LapCom** ambitionne de devenir une plateforme de référence où chaque visiteur peut non seulement trouver le produit recherché mais aussi vivre une expérience d'achat mémorable. Mon objectif est de créer un site intuitif, avec un catalogue vaste et facile à gérer, qui fidélise la clientèle et offre des méthodes de paiement sécurisées et adaptées.

---

## 🏢 **Contexte**
À ce jour, **LapCom** débute ses activités sans présence en ligne. Le défi est donc de créer de zéro la première interface e-commerce de l'entreprise, afin de lui permettre de se développer dans l'univers numérique.

---

## 🛠️ **Architecture du Projet**

### **Front Office**
- 🛍️ **Expérience Utilisateur :** Interface intuitive et navigation simplifiée.
- 🔐 **Authentification :** Système sécurisé pour une expérience d'achat personnalisée.
- 💳 **Paiement Sécurisé :** Intégration de paiements via **Stripe** et suivi des commandes.

### **Back Office**
- 🗃️ **Gestion de Contenu :** Administration des produits, utilisateurs et promotions.
- 📦 **Gestion des Stocks :** Suivi en temps réel et mises à jour automatiques.

---

## 🛠️ **Technologies Utilisées**

| Technologie | Description |
|-------------|-------------|
| ![Symfony](https://img.shields.io/badge/Symfony-Framework-000?style=for-the-badge&logo=symfony) | Backend puissant et sécurisé |
| ![MySQL](https://img.shields.io/badge/Database-MySQL-blue?style=for-the-badge&logo=mysql) | Base de données relationnelle |
| ![Apache](https://img.shields.io/badge/Server-Apache-red?style=for-the-badge&logo=apache) | Serveur web |
| ![HTML5](https://img.shields.io/badge/HTML5-Frontend-orange?style=for-the-badge&logo=html5) | Structure des pages |
| ![CSS3](https://img.shields.io/badge/CSS3-Styling-blue?style=for-the-badge&logo=css3) | Design responsive |
| ![JavaScript](https://img.shields.io/badge/JavaScript-Frontend-yellow?style=for-the-badge&logo=javascript) | Interactivité et fonctionnalités |

---

## 📦 **Installation**

Suivez ces étapes pour installer et lancer le projet localement :

1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/akamidev/LAPCOM.git
   cd LAPCOM

2. **Installer les dépendances :**

```bash
composer install
Configuration de la base de données :
```

```bash

php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
```
3. **Démarrer le serveur :**

```bash

symfony server:start

```
---
Accédez à http://127.0.0.1:8000/ dans votre navigateur.

### 📝 Fonctionnalités
🔍 Recherche de Produits : Filtrer les produits par nom, catégorie et prix.
🛒 Panier d'Achat : Ajouter, modifier et supprimer des articles.
💳 Paiement Sécurisé : Intégration avec Stripe pour des transactions sécurisées.
📈 Dashboard Admin : Visualiser les statistiques et gérer le contenu.

### 🚀 Améliorations Futures
🤖 Tests Automatisés : Ajouter des tests avec PHPUnit et Selenium.
🌐 Internationalisation : Support multi-langues pour une audience mondiale.
📱 Application Mobile : Développer une application pour iOS et Android.


### 🤝 Comment Contribuer
Fork le Dépôt
Créer une Branche (git checkout -b feature/ma-fonctionnalite)
Committer vos Changements (git commit -m 'Ajout de nouvelle fonctionnalité')
Pousser les Modifications (git push origin feature/ma-fonctionnalite)
Ouvrir une Pull Request


### 📄 Licence
Ce projet est sous licence MIT. Consultez le fichier LICENSE pour plus de détails.


### 📬 Contact
- **[LinkedIn](https://www.linkedin.com/in/akami-mehdi/)**
- **[Portfolio](https://akamimehdi.netlify.app/)**
- **Email : akamimehdi.dev@gmail.com**
  
⭐ N'oubliez pas de laisser une étoile sur ce projet si vous l'avez trouvé utile ! ⭐
