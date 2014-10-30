# Arbetsmarknadsguiden #

## Testfall ##

### TF 1.1  - Starta applikationen ###

**Input:**

1. Navigera in på sidan.

**Output:**

* Startsidan med navigationslänkar och sökformulär presenteras.

### TF 2.1 - Sökning på ett nyckelord ###

**Input:**

1. Navigera till startsidan.
2. Skriv in ett nyckelord (ex. "PHP") i sökfältet.
3. Ange ingen annan sökdata och säkerställ att formuläret och adress-fältet är fritt från andra sök-attribut.
4. Skicka formuläret.

**Output:**

* En egen sida för nyckelordet presenteras.
* En graf visas där nyckelordets frekvens över tid visas. Aktuell frekvens framgår tydligt i denna.
* Länkar till yrkesgrupper som nyckelordet förknippas med visas i en lista, sorterat efter vanlighet.
* Ett antal regioner där nyckelordet är vanligt visas i en lista, sorterat efter vanlighet.

### TF 2.2 - Sökning på region ###

**Input:**

1. Navigera till startsidan.
2. Ange en region (ex. "Kalmar län").
3. Ange ingen annan sökdata och säkerställ att formuläret och adress-fältet är fritt från andra sök-attribut.
4. Skicka formuläret.

**Output:**

* En egen sida för regionen presenteras.
* En länkad lista över vanliga yrkesgrupper i regionen visas.

### TF 2.3 - Sökning på yrkesgrupp ###

**Input:**

1. Navigera till startsidan.
2. Ange en yrkesgrupp (ex. "Systemutvecklare/Programmerare").
3. Ange ingen annan sökdata och säkerställ att formuläret och adress-fältet är fritt från andra sök-attribut.
4. Skicka formuläret.

**Output:**

* En egen sida för yrkesgruppen visas.
* En graf visar efterfrågan på yrkesgruppen över tid. (Ej implementerad)
* Ett länkat stapeldiagram med de vanligaste nyckelorden för yrkeskåren visas. (Ej implementerad)

### TF 2.4 - Sökning på nyckelord och region ###

**Input:**

1. Navigera till startsidan.
2. Skriv in ett nyckelord (ex. "PHP") i sökfältet.
3. Ange en region (ex. "Kalmar län").
4. Ange ingen annan sökdata och säkerställ att formuläret och adress-fältet är fritt från andra sök-attribut.
5. Skicka formuläret.

**Output:**

* Som 2.1, fast endast med data från den aktuella regionen.
* Regionens namn framgår tydligt på sidan.

### TF 2.5 - Sökning på nyckelord och yrkesgrupp ###

**Input:**

1. Navigera till startsidan.
2. Skriv in ett nyckelord (ex. "PHP") i sökfältet.
3. Ange ingen annan sökdata och säkerställ att formuläret och adress-fältet är fritt från andra sök-attribut.
4. Ange en yrkesgrupp (ex. "Systemutvecklare/Programmerare").
5. Skicka formuläret.

**Output:**

* Som 2.1, fast endast med data från den aktuella yrkesgruppen.
* En länkad lista med andra yrkesgrupper där nyckelordet är vanligt visas.
* En länkad lista med andra för yrkesgruppen vanliga nyckelord visas. (Ej implementerad)

### TF 2.6 - Sökning på region och yrkesgrupp ###

**Input:**

1. Navigera till startsidan.
2. Ange en region (ex. "Kalmar län").
3. Ange en yrkesgrupp (ex. "Systemutvecklare/Programmerare").
4. Ange ingen annan sökdata och säkerställ att formuläret och adress-fältet är fritt från andra sök-attribut.
5. Skicka formuläret.

**Output:**

* Ett länkat stapeldiagram med de vanligaste nyckelorden för yrkeskåren i regionen visas. (Ej implementerad)
* En graf som visar frekvensen på jobbannonser för yrkesgruppen i den regionen presenteras. (Ej implementerad)
* Regionens namn framgår tydligt på sidan. (Ej implementerad)

### TF 2.7 - Sökning på nyckelord, region och yrkesgrupp ###

**Input:**

1. Navigera till startsidan.
2. Skriv in ett nyckelord (ex. "PHP") i sökfältet.
3. Ange en region (ex. "Kalmar län").
4. Ange en yrkesgrupp (ex. "Systemutvecklare/Programmerare").
5. Ange ingen annan sökdata och säkerställ att formuläret och adress-fältet är fritt från andra sök-attribut.
6. Skicka formuläret.

**Output:**

* Som 2.1, fast endast med data från den aktuella regionen och inom yrkesgruppen.
* En länkad lista med andra yrkesgrupper i regionen där nyckelordet är vanligt visas. (Ej implementerad)
* En länkad lista med andra för yrkesgruppen vanliga nyckelord visas. (Ej implementerad)
* Regionens och yrkesgruppens namn framgår tydligt på sidan. (Ej implementerad)

### TF 3.1 - Manuell uppdatering av jobbdata ###

**Input:**

1. Navigera till startsidan.
2. Navigera vidare till Admin-sidan.
3. Notera tidsåtgången för den senaste uppdateringen av jobb-datan och kontrollera att uppdatering inte pågår.
4. Klicka på knappen "Uppdatera jobbinfo".
5. Vänta ungefär lika lång tid som tidsåtgången för den tidigare körningen.
6. Uppdatera sidan
**Om uppdatering fortfarande pågår, upprepa från steg 5**
**Om uppdatering fortfarande pågår efter två upprepningar, kontakta utvecklaren**

**Output:**

* Efter att ha klickat på knappen ska samma sida visas, men knappen skall vara inaktiverad och texten "Uppdatering pågår" skall visas.
* Sidan ska inte stå och "tugga", dvs skall vara färdigladdad.
* Efter att uppdateringen har avslutats skall information visas om tid och tidsåtgång för den senaste uppdateringen och knappen skall vara klickbar.

### TF 3.2 - Manuell uppdatering av regiondata ###

**Input:**

1. Navigera till startsidan.
2. Navigera vidare till Admin-sidan.
3. Notera tidsåtgången för den senaste uppdateringen av region-datan och kontrollera att uppdatering inte pågår.
4. Klicka på knappen "Uppdatera regioninfo".
5. Vänta ungefär lika lång tid som tidsåtgången för den tidigare körningen.
6. Uppdatera sidan
**Om uppdatering fortfarande pågår, upprepa från steg 5**
**Om uppdatering fortfarande pågår efter tre upprepningar, kontakta utvecklaren**

**Output:**

* Efter att ha klickat på knappen ska samma sida visas, men knappen skall vara inaktiverad och texten "Uppdatering pågår" skall visas.
* Sidan ska inte stå och "tugga", dvs skall vara färdigladdad.
* Efter att uppdateringen har avslutats skall information visas om tid och tidsåtgång för den senaste uppdateringen och knappen skall vara klickbar.

### TF 3.3 - Manuell uppdatering av jobbannonsdata ###

**Input:**

1. Navigera till startsidan.
2. Navigera vidare till Admin-sidan.
3. Notera tidsåtgången för den senaste uppdateringen av jobbannons-datan och kontrollera att uppdatering inte pågår.
4. Klicka på knappen "Samla jobbannonser".
5. Vänta ungefär lika lång tid som tidsåtgången för den tidigare körningen.
6. Uppdatera sidan
**Om uppdatering fortfarande pågår, upprepa från steg 5**
**Om uppdatering fortfarande pågår efter en upprepning, kontakta utvecklaren**

**Output:**

* Efter att ha klickat på knappen ska samma sida visas, men knappen skall vara inaktiverad och texten "Uppdatering pågår" skall visas.
* Sidan ska inte stå och "tugga", dvs skall vara färdigladdad.
* Efter att uppdateringen har avslutats skall information visas om tid och tidsåtgång för den senaste uppdateringen och knappen skall vara klickbar.