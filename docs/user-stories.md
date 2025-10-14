# User Stories - GetCooked

## Complete User Stories (Definitief - v2.0)

### ACCOUNT & PROFIEL

1. Als bezoeker wil ik een account kunnen aanmaken, zodat ik recepten kan uploaden en opslaan
2. Als gebruiker wil ik kunnen inloggen, zodat ik toegang krijg tot mijn account
3. Als gebruiker wil ik mijn profiel kunnen aanpassen met bio en foto, zodat andere users mij kunnen leren kennen
4. Als gebruiker wil ik mijn allergieën kunnen opgeven in mijn profiel, zodat ik geen recepten zie met allergenen
5. Als gebruiker wil ik voorkeuren kunnen instellen voor ingrediënten die ik niet wil eten, zodat ik alleen relevante recepten zie
6. Als gebruiker wil ik andere users kunnen volgen, zodat ik hun recepten kan bijhouden
7. Als gebruiker wil ik een feed kunnen zien met recepten van users die ik volg, zodat ik hun nieuwe recepten niet mis
8. Als gebruiker wil ik kunnen zoeken op ingrediënten en filteren op alleen recepten van gevolgde users, zodat ik gericht kan zoeken
9. Als gebruiker wil ik kunnen zien welke user een recept heeft geüpload, zodat ik hun profiel kan bezoeken

### RECEPT AANMAKEN

10. Als gebruiker wil ik een private recept kunnen aanmaken zonder goedkeuring, zodat ik recepten voor mezelf kan bewaren
11. Als gebruiker wil ik een public recept kunnen aanmaken dat goedgekeurd moet worden, zodat ik kwalitatieve recepten kan delen
12. Als gebruiker wil ik bij elk recept gestructureerd ingrediënten moeten invoeren (hoeveelheid, eenheid, naam), zodat het allergieën-systeem correct werkt
13. Als gebruiker wil ik bij elk recept verplichte bereidingsstappen moeten toevoegen, zodat andere users het kunnen namaken
14. Als gebruiker wil ik bij elk recept een foto moeten uploaden, zodat het visueel aantrekkelijk is
15. Als gebruiker wil ik duidelijke foto-guidelines zien (zelfgemaakt, geen AI), zodat ik weet wat er verwacht wordt
16. Als gebruiker wil ik bereidingstijd, moeilijkheidsgraad en aantal personen moeten opgeven, zodat recepten goed doorzoekbaar zijn

### RECEPT BEHEREN

17. Als gebruiker wil ik mijn private recepten kunnen bewerken, zodat ik verbeteringen kan aanbrengen
18. Als gebruiker wil ik mijn public recepten NIET kunnen bewerken, zodat de integriteit van goedgekeurde recepten gewaarborgd blijft
19. Als gebruiker wil ik al mijn recepten (private en public) kunnen verwijderen, zodat ik controle heb over mijn content
20. Als gebruiker wil ik een private recept public kunnen maken, zodat het alsnog gedeeld wordt (dit triggert approval proces)
21. Als gebruiker wil ik een public recept private kunnen maken, zodat het niet meer zichtbaar is voor anderen
22. Als gebruiker wil ik recepten kunnen dupliceren, zodat ik ze als template kan gebruiken

### GOEDKEURINGSPROCES

23. Als gebruiker wil ik een status zien (approved/pending/rejected) bij mijn public recepten, zodat ik weet of ze zichtbaar zijn
24. Als gebruiker wil ik bij afkeuring via mail contact kunnen opnemen met admin, zodat ik vragen kan stellen
25. Als admin wil ik ingediende public recepten kunnen reviewen op foto-kwaliteit en inhoud, zodat alleen echte recepten worden getoond
26. Als admin wil ik recepten kunnen goedkeuren of afwijzen, zodat nep-content eruit gefilterd wordt
27. Als admin wil ik bij afkeuring kunnen aangeven dat alleen de foto vervangen moet worden, zodat de user niet het hele recept opnieuw hoeft in te dienen
28. Als gebruiker wil ik een bevestiging ontvangen dat mijn public recept is ingediend voor review, zodat ik weet dat het in behandeling is
29. Als admin wil ik AI-analyse kunnen gebruiken (eerst handmatig, later automatisch) om recepten te beoordelen, zodat het approval proces efficiënter wordt
30. Als admin wil ik bij rejection kunnen aangeven of alleen de foto vervangen moet worden of het hele recept opnieuw moet, zodat de user duidelijke feedback krijgt

### INGREDIËNTEN SYSTEEM

59. Als gebruiker wil ik alleen ingrediënten kunnen selecteren die al in het systeem bestaan, zodat het allergenen-systeem betrouwbaar is
60. Als gebruiker wil ik een ontbrekend ingrediënt kunnen submitten voor toevoeging, zodat het later aan de database wordt toegevoegd
61. Als admin wil ik ingediende ingrediënten kunnen reviewen en toevoegen aan de database met allergeen-info en categorie, zodat de lijst actueel en betrouwbaar blijft

### TAGS & CATEGORISERING

28. Als gebruiker wil ik dat geselecteerde ingrediënten automatisch als tags worden toegevoegd, zodat mijn recept vindbaar is op ingrediënten
29. Als gebruiker wil ik handmatige categorie-tags kunnen toevoegen uit een voorgedefinieerde lijst, zodat ik mijn recept beter kan categoriseren
30. Als admin wil ik categorie-tags kunnen beheren en toevoegen, zodat de categorisering up-to-date blijft
31. Als gebruiker wil ik maximaal 5 handmatige categorie-tags kunnen selecteren, zodat mijn recept goed gecategoriseerd is zonder overload
32. Als gebruiker wil ik onbeperkt ingrediënt-tags automatisch gegenereerd krijgen op basis van mijn geselecteerde ingrediënten, zodat alle ingrediënten vindbaar zijn

### ZOEKEN & FILTEREN

31. Als gebruiker wil ik kunnen zoeken op één of meerdere ingrediënten tegelijk, zodat ik recepten vind met specifieke ingrediënten
32. Als gebruiker wil ik kunnen filteren op bereidingstijd, zodat ik recepten vind die bij mijn tijdschema passen
33. Als gebruiker wil ik kunnen filteren op moeilijkheidsgraad, zodat ik recepten vind die bij mijn niveau passen
34. Als gebruiker wil ik kunnen filteren op rating (YouTube-stijl like/dislike ratio), zodat ik de best beoordeelde recepten zie
35. Als gebruiker wil ik automatisch geen recepten zien die ingrediënten bevatten uit mijn allergieën/voorkeuren, zodat zoekresultaten veilig zijn

### INTERACTIE & WAARDERING

36. Als gebruiker wil ik recepten van andere users kunnen liken, zodat ik mijn waardering kan tonen
37. Als gebruiker wil ik recepten van andere users kunnen disliken, zodat ik feedback kan geven
38. Als gebruiker wil ik NIET kunnen wisselen tussen like en dislike, zodat waarderingen definitief zijn
39. Als gebruiker wil ik recepten aan mijn favorieten kunnen toevoegen, zodat ik ze snel terug kan vinden
40. Als gebruiker wil ik dat een favoriet automatisch een like toevoegt en een eventuele dislike overschrijft, zodat mijn waardering consistent is
41. Als gebruiker wil ik ongepaste recepten kunnen melden, zodat de community schoon blijft
42. Als admin wil ik meldingen direct ontvangen, zodat ik snel kan ingrijpen

### LIJSTEN & ORGANISATIE

43. Als gebruiker wil ik meerdere private lijsten kunnen aanmaken met eigen namen, zodat ik mijn recepten kan organiseren
44. Als gebruiker wil ik recepten aan mijn lijsten kunnen toevoegen, zodat ik collecties kan maken
45. Als gebruiker wil ik recepten uit lijsten kunnen verwijderen, zodat ik mijn lijsten actueel houd

### RECEPT WEERGAVE

46. Als gebruiker wil ik het aantal personen kunnen aanpassen, zodat de ingrediënten automatisch worden herberekend
47. Als gebruiker wil ik een kookmodus kunnen activeren waarbij het scherm niet uitgaat, zodat ik het recept makkelijk kan volgen tijdens het koken
48. Als gebruiker wil ik in kookmodus stap-voor-stap door de bereidingswijze kunnen navigeren, zodat ik overzichtelijk kan koken

### BOODSCHAPPENLIJST

49. Als gebruiker wil ik een boodschappenlijst kunnen samenstellen door meerdere recepten te selecteren, zodat ik in één keer kan zien wat ik moet kopen
50. Als gebruiker wil ik dat de boodschappenlijst automatisch wordt gerangschikt per categorie (vlees, groente, etc.), zodat winkelen efficiënt is
51. Als gebruiker wil ik items op de boodschappenlijst kunnen afvinken, zodat ik bijhoud wat ik al heb gekocht
52. Als gebruiker wil ik de boodschappenlijst kunnen exporteren, zodat ik hem extern kan gebruiken

### EXPORT & DELEN

53. Als gebruiker wil ik individuele recepten kunnen exporteren naar JSON of Markdown zonder foto, zodat ik ze extern kan opslaan
54. Als gebruiker wil ik boodschappenlijsten kunnen exporteren, zodat ik ze kan delen of printen
55. Als gebruiker wil ik recepten kunnen delen via een directe link, zodat anderen het recept kunnen bekijken zonder account
56. Als gebruiker wil ik recepten kunnen delen via social media buttons (WhatsApp, Facebook), zodat ik makkelijk kan delen met mijn netwerk
57. Als gebruiker wil ik een print-vriendelijke versie kunnen genereren, zodat ik het recept kan printen voor in de keuken

### ADMIN FUNCTIONALITEIT

56. Als admin wil ik users permanent kunnen bannen, zodat ze geen recepten meer kunnen posten
57. Als admin wil ik ervoor zorgen dat alle recepten van een gebane user automatisch worden verwijderd, zodat hun content verdwijnt
58. Als admin wil ik het categorie-tag-systeem kunnen beheren, zodat de categorisering consistent blijft

---

**Totaal: 69 user stories**
