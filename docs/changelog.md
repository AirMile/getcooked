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
- **30 oktober**: Bereidingsstappen functionaliteit voor recepten
    - RecipeStep model met one-to-many relatie naar Recipe
    - Dynamisch formulier met Alpine.js voor toevoegen/verwijderen van stappen
    - Minimum 1 en maximum 25 stappen validatie
    - Automatische genummering en herordening van stappen
    - Stappen worden weergegeven op recept detail pagina in geordende lijst
    - Database seeders aangepast met bereidingsstappen voor alle testdata
- **31 oktober**: UI/UX transformatie naar warm light theme
    - Styleguide aangemaakt met Karamel & Toffee color palette en Lora/Lato typography systeem
    - Tailwind config uitgebreid met alle styleguide design tokens (colors, fonts, spacing, shadows, transitions)
    - Complete transformatie van dark naar light theme voor dashboard, recipe pages en navigation
    - Dashboard header geoptimaliseerd: witte balk verwijderd voor minimalistisch design met betere visual hierarchy
    - UI refinements: icon-only buttons, gecentreerde search bar, subtielere kleuren voor meer focus op content
- **1 november**: Zoek- en filtersysteem geïmplementeerd
    - Routes hernoemd: /dashboard → /browse (publieke recepten), /recipes → /collection (eigen + opgeslagen recepten)
    - Search voor titel, beschrijving en ingrediënten
    - Browse pagina filters: Difficulty, Cook Time (quick/medium/long/very_long), Meal Type, Cuisine, Dietary Tags
    - Collection pagina filters: Source (own public/own private/saved), Difficulty, Cook Time, Meal Type
    - Query Scope Pattern: 6 herbruikbare scopes op Recipe model (search, byDifficulty, byCookTime, byMealType, byCuisine, byDietaryTags)
    - SourceFilter invokable class voor complexe filtering van eigen en opgeslagen recepten
    - Database indexes voor performance: composite index (status, created_at), individuele indexes (title, description, ingredient name)
    - Alpine.js filter panel met real-time updates en "Clear all" functionaliteit
    - Dietary tags filter gebruikt AND-logica (recepten moeten alle geselecteerde tags hebben)
    - Responsive filter UI: dropdown panel (desktop), toegankelijk via filter button in search bar
    - Client-side preventie: Alpine.js intercepteert recept indiening wanneer gebruiker al pending recept heeft
    - Modal popup toont naam van pending recept met directe link naar dat recept
    - "Hard block": voorkomt HTTP request wanneer spam limiet is bereikt (performance optimalisatie)
    - Server-side validatie blijft intact als backup (backwards compatible, werkt ook als JavaScript uit staat)
- **2 november**: Notificatiesysteem voor recept status updates
    - Laravel Notifications framework geïmplementeerd met database channel
    - Drie notificatie types: RecipeApproved, RecipeRejected, RecipeDeleted
    - Admin acties triggeren automatisch notificaties naar recept auteurs
    - Navbar toont unread count badge (rood bolletje met aantal, of "9+" bij meer dan 9)
    - Notificaties pagina met chronologische lijst (nieuwste eerst)
    - Context-aware navigatie knoppen: goedgekeurd→detail, afgekeurd→edit, verwijderd→nieuw
    - Rejection en deletion reasons worden getoond in notificatie cards
    - Mark-as-read functionaliteit (enkel en bulk "Mark All as Read")
    - Unread indicator op ongelezen notificaties
    - Notificatie data bevat recipe_title (blijft beschikbaar na verwijdering van recept)
    - Sla recipe data op in local storage bij Create & Edit van recipe

---

