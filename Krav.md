# Arbetsmarknadsguiden #
## Vision ##
Arbetsmarknadsguiden (AMG) �r ett statistiskt verktyg f�r studenter eller yrkesm�nniskor som vill utveckla de f�rdigheter som �r mest relevanta f�r deras yrkesgrupp.  
F�r att avg�ra detta s� samlar AMG in jobbannonser fr�n olika k�llor och s�ker igenom dem efter relevanta nyckelord. F�r en systemutvecklare skulle s�dana nyckelord kunna vara "C#", ".NET", "PHP" eller "MySQL". Frekvensen av dessa nyckelord antas st� i direkt relation till behovet av utvecklare med de kunskaperna. D�rmed kan efterfr�gan p� olika f�rdigheter och kunskaper h�rledas utifr�n detta.  
Ut�ver att se vilka f�rdigheter som �r relevanta i dagsl�get ska applikationen �ven kunna visa trender och historisk data.

## Krav ##
### Systemkrav ###
1. Systemet ska h�mta jobbannonser fr�n minst en k�lla.
2. Systemet ska lagra jobbannonser.

### Funktionskrav ###
1. Systemet ska kunna presentera intressant data f�r anv�ndaren utifr�n dennes val.
	1. Anv�ndaren ska kunna ange relevanta nyckelord som systemet sedan presenterar statistik �ver.
	2. Anv�ndaren ska kunna ange en region som �r s�rskilt intressant.
	3. Anv�ndaren ska kunna ange en yrkesk�r som �r s�rskilt intressant.
2. Systemet ska kunna presentera historisk data f�r att p�visa trender.

### Kvalitetskrav ###
1. Statistiken ska presenteras p� ett s�tt som g�r det l�tt f�r anv�ndaren att f�rst� den.
	1. Trender ska kunna presenteras i form av grafer.
	2. Nyckelordsfrekvens ska kunna presenteras i form av stapeldiagram eller "top 100"-listor.
2. Anv�ndarvalen ska vara tydliga.

## Anv�ndarfall (Use Cases) ##

### UC 1.1  - Anv�ndaren startar applikationen ###
Normal navigering in p� sidan.

**Input:**  
1. Anv�ndaren g�r in p� sidan.

**Output:**
* Startsidan presenteras.

### UC 1.2 - Anv�ndaren s�ker p� ett nyckelord ###
Enkel s�kning p� ett nyckelord.

**Input:**  
1. Anv�ndaren navigerar till startsidan.
2. Anv�ndaren skriver in ett nyckelord (ex. "PHP") i s�kf�ltet.
3. Anv�ndaren skickar formul�ret.

**Output:**
* En egen sida f�r nyckelordet presenteras.
* En graf visas d�r nyckelordets frekvens �ver tid visas. Aktuell frekvens framg�r tydligt i denna.
* L�nkar till yrkesgrupper som nyckelordet f�rknippas med visas i en lista, sorterat efter vanlighet.
* Ett antal regioner d�r nyckelordet �r vanligt visas i en lista, sorterat efter vanlighet.

### UC 1.3 - Anv�ndaren s�ker efter region ###
Anv�ndaren vill ha information om ett omr�de.

**Input:**  
1. Anv�ndaren navigerar till startsidan.
2. Anv�ndaren anger en region (ex. "Kalmar l�n").
3. Anv�ndaren skickar formul�ret.

**Output:**
* En egen sida f�r regionen presenteras.
* En l�nkad lista �ver vanliga yrkesgrupper i regionen visas.

### UC 1.4 - Anv�ndaren s�ker p� yrkesgrupp ###

**Input:**  
1. Anv�ndaren navigerar till startsidan.
2. Anv�ndaren anger en yrkesgrupp (ex. "Systemutvecklare").
3. Anv�ndaren skickar formul�ret.

**Output:**
* En egen sida f�r yrkesgruppen visas.
* En graf visar efterfr�gan p� yrkesgruppen �ver tid.
* Ett l�nkat stapeldiagram med de vanligaste nyckelorden f�r yrkesk�ren visas.

### UC 1.5 - Anv�ndaren s�ker p� ett nyckelord och anger region ###

**Input:**  
1. Anv�ndaren navigerar till startsidan.
2. Anv�ndaren skriver in ett s�kord (ex. "PHP") i s�kf�ltet.
3. Anv�ndaren anger en region (ex. "Kalmar l�n").
4. Anv�ndaren skickar formul�ret.
**Output:**
* Som 1.2, fast endast med data fr�n den aktuella regionen.
* Regionens namn framg�r tydligt p� sidan.

### UC 1.6 - Anv�ndaren s�ker p� ett nyckelord och anger yrkesgrupp ###

**Input:**  
1. Anv�ndaren navigerar till startsidan.
2. Anv�ndaren skriver in ett s�kord (ex. "PHP") i s�kf�ltet.
3. Anv�ndaren anger en yrkesgrupp (ex. "Systemutvecklare").
**Output:**
* Som 1.2, fast endast med data fr�n den aktuella yrkesgruppen.
* En l�nkad lista med andra yrkesgrupper d�r nyckelordet �r vanligt visas.
* En l�nkad lista med andra f�r yrkesgruppen vanliga nyckelord visas.

### UC 1.7 - Anv�ndaren s�ker p� region och yrkesgrupp ###

**Input:**  
1. Anv�ndaren navigerar till startsidan.
2. Anv�ndaren anger en region (ex. "Kalmar l�n").
3. Anv�ndaren anger en yrkesgrupp (ex. "Systemutvecklare").
4. Anv�ndaren skickar formul�ret.

**Output:**
* Ett l�nkat stapeldiagram med de vanligaste nyckelorden f�r yrkesk�ren i regionen visas.
* En graf som visar frekvensen p� jobbannonser f�r yrkesgruppen i den regionen presenteras.
* Regionens namn framg�r tydligt p� sidan.

### UC 1.8 - Anv�ndaren s�ker p� ett nyckelord och anger region och yrkesgrupp ###

**Input:**  
1. Anv�ndaren navigerar till startsidan.
2. Anv�ndaren skriver in ett s�kord (ex. "PHP") i s�kf�ltet.
3. Anv�ndaren anger en region (ex. "Kalmar l�n").
4. Anv�ndaren anger en yrkesgrupp (ex. "Systemutvecklare").
5. Anv�ndaren skickar formul�ret.

**Output:**
* Som 1.2, fast endast med data fr�n den aktuella regionen och inom yrkesgruppen.
* En l�nkad lista med andra yrkesgrupper i regionen d�r nyckelordet �r vanligt visas.
* En l�nkad lista med andra f�r yrkesgruppen vanliga nyckelord visas.
* Regionens och yrkesgruppens namn framg�r tydligt p� sidan.