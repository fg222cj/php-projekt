# Arbetsmarknadsguiden #
## Vision ##
Arbetsmarknadsguiden (AMG) är ett statistiskt verktyg för studenter eller yrkesmänniskor som vill utveckla de färdigheter som är mest relevanta för deras yrkesgrupp.  
För att avgöra detta så samlar AMG in jobbannonser från olika källor och söker igenom dem efter relevanta nyckelord. För en systemutvecklare skulle sådana nyckelord kunna vara "C#", ".NET", "PHP" eller "MySQL". Frekvensen av dessa nyckelord antas stå i direkt relation till behovet av utvecklare med de kunskaperna. Därmed kan efterfrågan på olika färdigheter och kunskaper härledas utifrån detta.  
Utöver att se vilka färdigheter som är relevanta i dagsläget ska applikationen även kunna visa trender och historisk data.

## Krav ##
### Systemkrav ###
1. Systemet ska hämta jobbannonser från minst en källa.
2. Systemet ska lagra jobbannonser.

### Funktionskrav ###
1. Systemet ska kunna presentera intressant data för användaren utifrån dennes val.
	1. Användaren ska kunna ange relevanta nyckelord som systemet sedan presenterar statistik över.
	2. Användaren ska kunna ange en region som är särskilt intressant.
	3. Användaren ska kunna ange en yrkeskår som är särskilt intressant.
2. Systemet ska kunna presentera historisk data för att påvisa trender.

### Kvalitetskrav ###
1. Statistiken ska presenteras på ett sätt som gör det lätt för användaren att förstå den.
	1. Trender ska kunna presenteras i form av grafer.
	2. Nyckelordsfrekvens ska kunna presenteras i form av stapeldiagram eller "top 100"-listor.
2. Användarvalen ska vara tydliga.

## Användarfall (Use Cases) ##

### UC 1.1  - Användaren startar applikationen ###
Normal navigering in på sidan.

**Input:**  
1. Användaren går in på sidan.

**Output:**
* Startsidan presenteras.

### UC 1.2 - Användaren söker på ett nyckelord ###
Enkel sökning på ett nyckelord.

**Input:**  
1. Användaren navigerar till startsidan.
2. Användaren skriver in ett nyckelord (ex. "PHP") i sökfältet.
3. Användaren skickar formuläret.

**Output:**
* En egen sida för nyckelordet presenteras.
* En graf visas där nyckelordets frekvens över tid visas. Aktuell frekvens framgår tydligt i denna.
* Länkar till yrkesgrupper som nyckelordet förknippas med visas i en lista, sorterat efter vanlighet.
* Ett antal regioner där nyckelordet är vanligt visas i en lista, sorterat efter vanlighet.

### UC 1.3 - Användaren söker efter region ###
Användaren vill ha information om ett område.

**Input:**  
1. Användaren navigerar till startsidan.
2. Användaren anger en region (ex. "Kalmar län").
3. Användaren skickar formuläret.

**Output:**
* En egen sida för regionen presenteras.
* En länkad lista över vanliga yrkesgrupper i regionen visas.

### UC 1.4 - Användaren söker på yrkesgrupp ###

**Input:**  
1. Användaren navigerar till startsidan.
2. Användaren anger en yrkesgrupp (ex. "Systemutvecklare").
3. Användaren skickar formuläret.

**Output:**
* En egen sida för yrkesgruppen visas.
* En graf visar efterfrågan på yrkesgruppen över tid.
* Ett länkat stapeldiagram med de vanligaste nyckelorden för yrkeskåren visas.

### UC 1.5 - Användaren söker på ett nyckelord och anger region ###

**Input:**  
1. Användaren navigerar till startsidan.
2. Användaren skriver in ett sökord (ex. "PHP") i sökfältet.
3. Användaren anger en region (ex. "Kalmar län").
4. Användaren skickar formuläret.
**Output:**
* Som 1.2, fast endast med data från den aktuella regionen.
* Regionens namn framgår tydligt på sidan.

### UC 1.6 - Användaren söker på ett nyckelord och anger yrkesgrupp ###

**Input:**  
1. Användaren navigerar till startsidan.
2. Användaren skriver in ett sökord (ex. "PHP") i sökfältet.
3. Användaren anger en yrkesgrupp (ex. "Systemutvecklare").
**Output:**
* Som 1.2, fast endast med data från den aktuella yrkesgruppen.
* En länkad lista med andra yrkesgrupper där nyckelordet är vanligt visas.
* En länkad lista med andra för yrkesgruppen vanliga nyckelord visas.

### UC 1.7 - Användaren söker på region och yrkesgrupp ###

**Input:**  
1. Användaren navigerar till startsidan.
2. Användaren anger en region (ex. "Kalmar län").
3. Användaren anger en yrkesgrupp (ex. "Systemutvecklare").
4. Användaren skickar formuläret.

**Output:**
* Ett länkat stapeldiagram med de vanligaste nyckelorden för yrkeskåren i regionen visas.
* En graf som visar frekvensen på jobbannonser för yrkesgruppen i den regionen presenteras.
* Regionens namn framgår tydligt på sidan.

### UC 1.8 - Användaren söker på ett nyckelord och anger region och yrkesgrupp ###

**Input:**  
1. Användaren navigerar till startsidan.
2. Användaren skriver in ett sökord (ex. "PHP") i sökfältet.
3. Användaren anger en region (ex. "Kalmar län").
4. Användaren anger en yrkesgrupp (ex. "Systemutvecklare").
5. Användaren skickar formuläret.

**Output:**
* Som 1.2, fast endast med data från den aktuella regionen och inom yrkesgruppen.
* En länkad lista med andra yrkesgrupper i regionen där nyckelordet är vanligt visas.
* En länkad lista med andra för yrkesgruppen vanliga nyckelord visas.
* Regionens och yrkesgruppens namn framgår tydligt på sidan.