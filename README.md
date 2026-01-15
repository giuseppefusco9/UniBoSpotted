# UniBoSpotted
/unibo-spotted
├── css/
│   └── style.css           # Personalizzazioni CSS (oltre a Bootstrap)
├── js/
│   └── script.js           # Logica Frontend (Vanilla JS, niente framework come React/Vue) [cite: 128]
├── img/                    # Loghi e asset statici
├── upload/                 # Cartella per immagini caricate dagli studenti (WOW effect)
├── db/
│   └── database.php        # Connessione al DB e configurazione
├── template/               # Pezzi di HTML riutilizzabili
│   ├── header.php          # Navbar (con logiche diverse per Admin/User)
│   ├── footer.php
│   └── sidebar.php         # Filtri categorie (es. Annunci, Persone, Servizi)
├── utils/
│   └── functions.php       # Funzioni helper (es. sanitizzazione input, gestione sessione)
├── admin/                  # Area riservata Admin [cite: 16, 39]
│   ├── dashboard.php       # Panello principale gestione contenuti
│   ├── delete_post.php     # Logica eliminazione spot
│   └── manage_users.php    # Gestione utenti (opzionale ma utile)
├── doc_design/             # Documentazione di progetto obbligatoria
│   ├── personas.pdf        # Personas e Scenarios [cite: 62]
│   ├── mockup_mobile.pdf   # Mockup versione Mobile 
│   ├── mockup_desktop.pdf  # Mockup versione Desktop 
│   └── relazione.pdf       # Relazione (max 1 pagina) [cite: 111]
├── login.php               # Pagina di Login [cite: 36]
├── register.php            # Pagina di Registrazione [cite: 36]
├── profile.php             # Profilo Utente (storico spot inviati, dati) 
├── index.php               # Homepage (bacheca pubblica degli spot)
├── submit_spot.php         # Pagina/Logica per inviare un nuovo spot
└── logout.php              # Chiusura sessione