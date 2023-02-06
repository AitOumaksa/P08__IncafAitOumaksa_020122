ToDoList
========

Base du projet #8 : Améliorez un projet existant


## Livrable :

   Un dossier dans (branche version_2.0) docs/test-coverage.zips : analyse généré par PHPUnit indiquant le taux de couverture de code des tests réalisées.
        
   Un dossier dans (branche version_2.0) UML : Diagrammes UML demandés.
        
   Un fichier dans (branche version_2.0) docs/CONTRIBUTE.md : Documentation indiquant comment contribuer au projet.
        
   Un fichier dans (branche version_2.0) docs/Documentation_technique.pdf : Documentation technique concernant l'authentification.
        
   Un fichier dans (branche version_2.0) docs/audit_qualité_performance.pdf : Rapport audit de qualité de code et de performance.
        
        
 ## Environnement de développement :
    
    
       Symfony 5.4 LTS.
       
       Composer 2.5 .
       
          Mamp:
            
             Php 7.4.
             
             Apache 2.4.
             
             MySQL 5.7.24 
             
## Instalation :

1- Clonez le repository GitHub dans le dossier voulu :

     git clone  https://github.com/AitOumaksa/P08__IncafAitOumaksa_020122.git
  
 2- Placez vous dans le répertoire de votre projet et installez les dépendances du projet avec la commande de Composer :            

       composer install
 
 3- Configurez vos variables d'environnement dans le fichier .env tel que :
 
    La connexion à la base de données : 
       
              DATABASE_URL=mysql://db.username:db.password@127.0.0.1:3306/todo_and_co
              
4- Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
 
      php bin/console doctrine:database:create
      
 5- Créez les différentes tables de la base de données en appliquant les migrations :
 
      php bin/console doctrine:migrations:migrate
      
 6- Installez les fixtures pour tester le site :   
      php bin/console doctrine:fixtures:load
      

## Tester l'application (optionnel) :

Des tests ont été écrits afin de vérifier l'intégrité et le fonctionnement de l'application. Afin de pouvoir les lancer :

1- Configurer la base de données des test dans le fichier .env.test, a la base de données de test voulue:

        DATABASE_URL=mysql://db.username:db.password@127.0.0.1:3306/todo_and_co_test
        
 2- Créez la base de données de test :
        
           php bin/console doctrine:database:create --env=test
           
 3- Lancez le test via la commande :
 
          php  vendor/bin/phpunit
          
4- Vous pouvez générer un test de couverture de code avec la commande ci-dessous (Le résultat est disponible à dans ./public/test-coverage/index.html:

           php   vendor/bin/phpunit --coverage-html public/test-coverage
     


