/*CONSEGNA DEL 03-10-24*/

Esercizio di oggi: Laravel Boolfolio - Base
nome repo: laravel-auth
Ciao ragazzi, creiamo con Laravel il nostro sistema di gestione del nostro Portfolio di progetti. Oggi iniziamo un nuovo progetto che si arricchirà nel corso delle prossime lezioni: man mano aggiungeremo funzionalità e vedremo la nostra applicazione crescere ed evolvere. Nel pomeriggio, rifate ciò che abbiamo visto insieme stamattina stilando tutto a vostro piacere utilizzando SASS.
Descrizione: Ripercorriamo gli steps fatti a lezione ed iniziamo un nuovo progetto usando laravel breeze ed il pacchetto Laravel 9 Preset con autenticazione.
Iniziamo con il definire il layout, modello, migrazione, controller e rotte necessarie per il sistema portfolio:
Autenticazione: si parte con l'autenticazione e la creazione di un layout per back-office
Creazione del modello Project con relativa migrazione, seeder, controller e rotte
Per la parte di back-office creiamo un resource controller Admin\\ProjectController per gestire tutte le operazioni CRUD dei progetti.
Fate le crud viste a lezione: index, show, create e store
Bonus
Implementiamo la validazione dei dati dei Progetti nelle operazioni CRUD che lo richiedono usando due form requests.

/*CONSEGNA DEL 04-10-24*/

continuate con la repo aperta ieri realizzando le CRUD mancanti, ovvero edit, update e destroy. Per la destroy è richiesta obbligatoriamente la richiesta di conferma di cancellazione, scegliete voi come farla se con la confirm o con la modale di bootstrap.
Bonus: realizzate la validazione dei campi anche per l'edit


/*SOLUZIONE*/

- Installo il progeto base di laravel, con l'aggiunta dei pacchetti e comandi di installazione riguardanti l'autentificazione
- Creo una cartella partials all'interno di resources/views/layouts, quindi creo il file header.blade.php.
    NB: chiedo venia per i miei tempi ma prima ho voluto ripassare la lezione di stammatiina.
- modifico app.blade per inlcudere header.blade.php.
- Crea il modello e la migrazione associata con il comando php artisan make:model Project -m
- Modifico la migrazione 2024_10_03_175552_create_projects_table.
- modifico il file .env per modificare il DB_DATABASE in laravel_auth.
- in phpMyAdmin creo il database laravel_auth.
- eseguo la migrazione con il comando php artisan migrate.
- creo un seeder con il comando php artisan make:seeder ProjectSeeder.
- effettuo la chiamata del seeder in DatabaseSeeder.php.
- eseguo il seeder con il comando php artisan db:seed --class=ProjectSeeder
- creo un controller di tipo resource per il back-office con il comando php artisan make:controller Admin/ProjectController --resource
- aggiorno ProjectController.php per includere i metodi CRUD index, show, create e store.
- modifico web.php per le views di index, show, create e store.
- creo il file index.blade.php.
- creo il file create.blade.php.
- prima ho tolto l'auth nel web.php perché altrimenti non potevo accedere all'elenco dei progetti se non eseguivo il login
- in heade.blade.php ho sostitiuito 
    
    <a class="nav-link" href="{{ route('admin.projects.index') }}">Progetti</a>
    
    con
    
    <a class="nav-link" href="{{ route('projects.index') }}">Progetti</a>
  
  perché per qualche motivo laravel non mi trovava l'index. Togliendo admin ho finalmente avuto accesso all'elenco dei progetti alla pagina che mi permette di crearne di nuovi. 

- per adesso terrò la commentata la auth in web.php visto il problema che ho descritto.

- lancio il comando php artisan make:request StoreProjectRequest per creare il StoreProjectRequest, il quale conterrà delle regole di validazione per la creazione di nuovi progetti.
    -imposto le regole di validazione di StoreProjectRequest.
- aggiungo i metodi edit ed update in ProjectController.php
    - aggiungendo il metodo update inserisco anche le regole di validazione per l'aggiornamento dei dati
- creo il file edit.blade.php e ne scrivo il relativo codice con tanto di regole di validazione.
- modifico index.blade.php per aggiungere il pulsante "Modifica" relativo ad edit.blade.php. E visto che ci sono sono aggiungo un form per l'eliminazione di un progetto usando il metodo POST con l'annotazione @method('DELETE').
- ma per far fuonzionare correttamente il bottone Elimina, aggiungo anche il metdo delete nel ProjectController.
- lancio il comando php artisan make:request UpdateProjectRequest per creare l'iomonima Form Request.
- modifico ProjectController.php per implementare correttamente UpdateProjectRequest.
- aggiungo una conferma per la cancellazione e provo a farlo attraverso la modale di boostrap.
- decido di creare manualmente un utente fitizzio che ricopra il ruolo di amnistratore. In questo modo ddovrei implementare l'autentificazione alla repo.
    - modifico ProjectSeeder.php per creare manualmente l'utente amnistratore.
    - tramite il comando php artisan make:migration add_is_admin_to_users_table --table=users creo una nuova migrazione con tabella riguardante gli utenti e con lo stesso comando aggiungo una colonna dedicata esclusivamente all'amnistratore.
    - lancio la migrazione con il comando php artisan migrate.
    - modifico il file web.php in modo tale che solo degli utenti autenticati, come appunto l'amnistratore, possano accedere a determinati link tramite middleware.
    - lancio il comando php artisan make:middleware AdminMiddleware per creare l'omonimo file.
    - modifico AdminMiddleware.php in modo tale che solo l'utente amnistraotore abbia l'accesso.
    - modifico il file kernel.php per registrare il middleware riguardante l'amnistratore.
    - aagiungo una logica di controllo a header.blade.php affinché solo un amministatore autenticato possa gestire i progetti.
- Ho dovuto riscrivere il codice dei file Kernel.php, header.blade.php, web.php, 2024_10_06_174326_add_is_admin_to_users_table.php, ProjectSeeder.php. E per questi ultimi due ho effettuato i comandi php artisan migrate:rollback, php artisan migrate e php artisan db:seed --class=ProjectSeeder perché ho dovuto rifare la migrazione e la popolazione. Adesso, se vado sul link datomi dal comando php -S localhost:8000 -t public/, il browser ti blocca subito in quanto solo un utente registrato può accedere a questo indirizzo. Il logine funziona corettamente. Non sono riuscito a fare di meglio.
- modifico il file ProjectController.php per includere lo slug