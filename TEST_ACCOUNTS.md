# GetCooked Test Accounts

Deze file bevat alle test accounts die worden aangemaakt door de database seeder. Gebruik deze credentials om in te loggen en de applicatie te testen.

## Admin Account

**Voor het beheren van recepten en gebruikers**

| Email | Wachtwoord | Rol | Recepten |
|-------|------------|-----|----------|
| admin@getcooked.test | admin123 | admin | 0 |

**Wat kun je als admin:**
- Goedkeuren of afkeuren van pending recepten
- Bekijken van alle public recepten
- Gebruikers beheren (indien geïmplementeerd)

---

## Private User Account

**Gebruiker met alleen private recepten**

| Email | Wachtwoord | Rol | Private Recepten |
|-------|------------|-----|------------------|
| private@getcooked.test | password | user | 5 |

**Private recepten van deze gebruiker:**
1. My Secret Chocolate Cake (geen foto)
2. Grandma's Apple Pie (met placeholder foto)
3. Personal Protein Smoothie (geen foto)
4. Quick Garlic Noodles (met placeholder foto)
5. Meal Prep Chicken Bowl (geen foto)

---

## Regular User Accounts

**12 gebruikers die public recepten hebben gemaakt**

| Email | Wachtwoord | Rol |
|-------|------------|-----|
| user1@getcooked.test | password | user |
| user2@getcooked.test | password | user |
| user3@getcooked.test | password | user |
| user4@getcooked.test | password | user |
| user5@getcooked.test | password | user |
| user6@getcooked.test | password | user |
| user7@getcooked.test | password | user |
| user8@getcooked.test | password | user |
| user9@getcooked.test | password | user |
| user10@getcooked.test | password | user |
| user11@getcooked.test | password | user |
| user12@getcooked.test | password | user |

---

## Database Statistics

**Na het runnen van de seeder heb je:**

- **Totaal users:** 14 (1 admin + 1 private user + 12 regular users)
- **Totaal recepten:** 35
  - Private: 5 recepten
  - Approved: 20 recepten (zichtbaar voor iedereen)
  - Pending: 7 recepten (wachten op admin goedkeuring)
  - Rejected: 3 recepten (afgekeurd met reden)

**Interacties:**
- ~100-150 likes en dislikes op approved recepten
- Viral recepten (Emily Mariko, Gigi Hadid, Baked Feta) hebben 80%+ like ratio
- Andere recepten hebben 70%+ like ratio
- 30-50 saved recipes (favorites) verdeeld over alle users

**Foto's:**
- Alle public recepten hebben faker placeholder images
- Private recepten: 50% met placeholder, 50% zonder

---

## Recepten Overzicht per Status

### Approved Recepten (20) - Public en zichtbaar

**Viral TikTok/Instagram Hits:**
1. Emily Mariko Salmon Rice Bowl (Japanese, Lunch)
2. Gigi Hadid Vodka Pasta (Italian, Dinner)
3. Baked Feta Pasta (Greek, Dinner)

**Breakfast:**
4. Fluffy Buttermilk Pancakes (American)
5. Belgian Waffles (Belgian)
6. Eggs Benedict (American)

**Asian Cuisine:**
7. Pad Thai (Thai)
8. Chicken Katsu (Japanese)
9. Thai Green Curry (Thai)
10. Korean Bibimbap (Korean)
11. Kung Pao Chicken (Chinese)

**Mexican Cuisine:**
12. Beef Tacos with Fresh Salsa
13. Chicken Enchiladas
14. Loaded Nachos

**Mediterranean:**
15. Classic Greek Salad
16. Spanish Paella

**Vegetarian/Vegan:**
17. Vegan Buddha Bowl (Mediterranean)

**Desserts:**
18. Fudgy Chocolate Brownies (American)
19. Tiramisu (Italian)
20. Matcha Green Tea Cake (Japanese)

### Pending Recepten (7) - Wachten op goedkeuring

1. Classic Carbonara (Italian, Dinner)
2. Birria Tacos (Mexican, Dinner - 3 uur kooktijd!)
3. Shrimp Fried Rice (Chinese, Dinner)
4. French Toast with Berries (French, Breakfast)
5. Caprese Salad (Italian, Salad)
6. Mediterranean Chickpea Bowl (Mediterranean, Lunch)
7. Chicken Dumplings (Chinese, Appetizer)

### Rejected Recepten (3) - Afgekeurd

1. Scrambled Eggs - "Te kort, geen details"
2. Microwave Pizza - "Geen echte kookvaardigheden"
3. Boiled Water - "Dit is geen recept"

---

## Workflow voor Demonstratie

### 1. Database Setup
```bash
php artisan migrate:fresh --seed
```

### 2. Als Admin
1. Login met admin@getcooked.test / admin123
2. Browse door de 20 approved recepten
3. Bekijk de 7 pending recepten (admin panel)
4. Keur recepten goed of af
5. Upload echte images bij je favoriete recepten via edit functie

### 3. Als Private User
1. Login met private@getcooked.test / password
2. Bekijk je 5 private recepten
3. Demonstreer dat deze niet zichtbaar zijn voor anderen

### 4. Als Regular User
1. Login met user1@getcooked.test / password
2. Browse door approved recepten
3. Like/dislike recepten
4. Save favorites
5. Bekijk je eigen recepten

---

## Tips voor Demonstratie

**Best om te tonen:**
1. **Viral recepten** - Emily Mariko Salmon Bowl, Gigi Hadid Pasta - hebben veel likes!
2. **Diverse cuisines** - Laat zien dat je Thai, Japanese, Mexican, Italian, etc. hebt
3. **Pending workflow** - Laat zien hoe admin recepten goedkeurt
4. **Private recepten** - Demonstreer dat private recepten alleen voor de maker zichtbaar zijn
5. **Rejected recepten** - Laat zien waarom recepten worden afgekeurd

**Voor de beste presentatie:**
- Upload echte food images bij de top 10 populairste approved recepten
- De placeholders zijn nu faker URLs, dus je kunt zelf kiezen welke recepten images krijgen
- Focus op de recepten met de meeste likes voor je demonstratie

---

## Snelle Login Referentie

| Account Type | Email | Password |
|--------------|-------|----------|
| 🔑 Admin | admin@getcooked.test | admin123 |
| 🔒 Private User | private@getcooked.test | password |
| 👤 Regular Users | user1-12@getcooked.test | password |

Alle wachtwoorden zijn gehasht met bcrypt en veilig opgeslagen in de database.
