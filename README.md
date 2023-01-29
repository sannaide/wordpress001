Sperimentazione con Wordpress

- utilizzo di un layout custom
- come includere i fogli di stile via codice (risolvendo il problema della cache)
- come includere javascript via codice (risolvendo il problema della cache)
- inclusione header, contenuto e footer
- esecuzione shortcode mio custom (la lista degli articoli è uno shortcode)
- esecuzione di javascript nativo e con jQuery

Faccio uso del plugin Snippets

- in snippets/* ci sono tutti gli snippet

Ho creato la directory "mainpage" in wp-content\themes

e lì ho messo i file
- components (dir) -> sviluppo per componenti
  ogni sottodirectory è un componente se contiene
  css (dir) e js (dir).
  Ad esempio c'è la directory mainmenu che contiene
  header sticky e sliding ovvero tre versioni del
  menu principale
- header.php
- index.php
- footer.php
- style.css
