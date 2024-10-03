/*CONSEGNA*/

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


/*SOLUZIONE*/

- Installo il progeto base di laravel, con l'aggiunta dei pacchetti e comandi di installazione riguardanti l'autentificazione
- Creo una cartella partials all'interno di resources/views/layouts, quindi creo il file header.blade.php.
    NB: chiedo venia per i miei tempi ma prima ho voluto ripassare la lezione di stammatiina.
- modifico app.blade per inlcudere header.blade.php.
- Crea il modello e la migrazione associata con il comando php artisan make:model Project -m
- Modifico la migrazione 2024_10_03_175552_create_projects_table.
- modifico il file .env per modificare il DB_DATABASE in laravel_auth.
- in phpMyAdmin creo il database laravel_auth.