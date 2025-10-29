# Changelog - GetCooked Project

Hier houd ik bij wat ik heb gedaan tijdens het project.

---

## Week 1 - 13 oktober 2025

### Wat ik heb gedaan
- **14 oktober**: Project opzet
  - ERD ontworpen voor de database structuur
  - 69 user stories geschreven en georganiseerd per categorie
  - Documentatiestructuur opgezet (docs/ folder met changelog, user-stories en images folder)
- **18 oktober**: Role-based access control geïmplementeerd
  - Database migration aangemaakt voor role enum column (user/admin) met default 'user'
  - User model beveiligd tegen mass assignment attacks (role NIET in $fillable)
  - Register link toegevoegd aan login pagina
  - Route protection strategie gedocumenteerd (alleen landing page is publiek toegankelijk)
  - Database seeders aangepast met admin user (Miles) en 5 test users

---


## Week 2 - 20 oktober 2025

### Wat ik heb gedaan
- **25 oktober**: Database fundament voor receptenbeheer systeem
  - Recipe model met status workflow (private, pending, approved, rejected)
  - Ingredient model met recipe relaties en volgorde
  - Like systeem voor recepten (like/dislike functionaliteit)
  - User-recipe relaties (eigenaarschap, opgeslagen recepten)
  - Uitgebreide model factories voor testing
  - 14 geautomatiseerde unit tests voor models en relaties
- **26 oktober**: Navigatie systeem en dashboard transformatie
    - Role-based navigatie met aparte user en admin componenten
    - User navigatie: Public Recipes, My Recipes, Create Recipe, Saved Recipes
    - Admin navigatie: Pending Recipes, Public Recipes moderation, Users Management
    - Search bar component (placeholder voor toekomstige zoekfunctie)
    - Dashboard omgebouwd naar public recipes browse view met paginatie
    - Recipe cards met foto, metadata en like/dislike ratios
    - Mobile-responsive navigatie met Alpine.js toggle functionaliteit

## Week 3 - 27 oktober 2025

### Wat ik heb gedaan
- **27 oktober**: Geverifieerde gebruikers systeem met toggle functionaliteit
    - Admin kan gebruikers verifiëren via slider op /admin/users pagina
    - Admin kan recept privacy (privé <-> goedgekeurd) aanpassen via slider op /admin/users/{id}/recipes pagina
    - Geverifieerd badge (blauw vinkje icoon) wordt getoond naast recept auteurs op publieke pagina's
    - Geverifieerde gebruikers slaan goedkeuringsproces over bij het publiceren van recepten
    - Standaard gebruikers hebben admin goedkeuring nodig voor publieke recepten
    - Aparte POST controller acties voor elke toggle
    - Alpine.js Ajax sliders met error handling en slider terugdraai functie bij fouten
- **28 oktober**: Spam preventie systeem
    - Spam preventie voor nieuwe gebruikers: maximaal 1 pending recept totdat eerste recept is goedgekeurd
    - Custom Laravel validatie regel voor spam preventie tijdens recept indienen
    - Gebruikers worden permanent ontgrendeld na eerste goedgekeurd recept
    - Afgekeurde recepten tellen niet mee, gebruiker kan direct nieuw recept uploaden
    - Geverifieerde gebruikers omzeilen alle spam preventie beperkingen
- **29 oktober**: Bug fix reject modal van pending recipes
    - Admin kan recepten rejecten met specifieke reden
---

## Week 4 - 3 november 2025 (Deadline: 10 november)

### Wat ik heb gedaan


---
