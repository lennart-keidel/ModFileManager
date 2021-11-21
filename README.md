# CC-Magic - einrichten, Dateinamen festlegen,  dokumentieren, genau überlegen, wie am besten

Datum Zusammenfassung: Sep 14, 2020
Datum letzte Bearbeitung: Nov 21, 2021 5:28 PM

[❗ CC Magic - Anleitung, sehr wichtige Erkenntnisse](https://www.notion.so/CC-Magic-Anleitung-sehr-wichtige-Erkenntnisse-eca028c6bd534e16984c7c902a43919a)

[❌✔ CC Magic - bekannte Bugs + Lösung](https://www.notion.so/CC-Magic-bekannte-Bugs-L-sung-f57f8f7a8e41477ca8a37b8b69aab057)

[Store - via CC-Magic oder Launcher installieren? Entscheidung anhand von allen gesammelten Daten und Tests](https://www.notion.so/Store-via-CC-Magic-oder-Launcher-installieren-Entscheidung-anhand-von-allen-gesammelten-Daten-und-39016225f5344bf58ada06cf878a39ea)

[CC-Magic - alternativen Overrides Ordner für CC-Magic anlegen](https://www.notion.so/CC-Magic-alternativen-Overrides-Ordner-f-r-CC-Magic-anlegen-66401ed026f646ef81fa12ae6746a617)

[✔ CC Magic - Grundstücke via CC-Magic installieren? + Ergebnis](https://www.notion.so/CC-Magic-Grundst-cke-via-CC-Magic-installieren-Ergebnis-db6fa778d611478397157ea3d6c870bc)

[✔ CC-Magic - Fehler bei Dateien mit gleichen Namen? + Ergebnis](https://www.notion.so/CC-Magic-Fehler-bei-Dateien-mit-gleichen-Namen-Ergebnis-639dda1409f440729f851f269ea2e779)

**Inhaltsverzeichnis**

## Erklärung Konzept

- **Schema nach dem Dateien benannt werden**
    - Beschreibung des Konzepts
        - Schema des Dateinamen setzt sich aus diesen Teilen zusammen
        - Reihenfolge ist wichtig
        - kein Schema-Teil darf optional sein, jeder Schema-Teil muss Daten haben
        - Teile des Schema werden mit doppeltem Unterstrich getrennt
        - im Dateinamen sind nur diese Zeichen erlaubt [A-Za-z0-9_]
        - alle nicht gültigen Zeichen werden zu einem Unterstrich ersetzt
        - doppelte Unterstriche werden mit einem Unterstrich ersetzt, um sie nicht mit dem Trennen der Schema-Teile zu verwechseln
    - Kategorie, welche Art von Mod-Inhalt es ist, nur eines möglich
        - COR = Core Mod
        - DR = Default Replacemant
        - TUN = Tuning
        - SCR = Script
        - CAS = Create a Sim
        - CCSCR = Custom Content Objekt mit eigenem Script/Funktion
        - CCBUY = Custom Content Objekt aus Kaufmodus
        - CCBUI = Custom Content Objekt aus Baumodus
        - OTH = keine der anderen Kategorien
    - Mod Beschreibung (ca. 1-17 Worte, max 75 Zeichen)
        - notwendig, damit Dateinamen einzigartig sind
            - Short Link macht Dateinamen nicht garantiert einzigartig
            - wenn es der gleiche Link ist für mehrere Dateien ist es auch der gleiche Shortlink
        - bei CC kann auch CC-Set-Name vom Download sein
        - **kann max. 75 Zeichen lang sein!**
            - Pfad-Länge ist in Windows auf 247 Zeichen begrenzt (in offizieller Windows Dokumentation steht 260 Zeichen)
                - habe mit Bash Zeichen der Pfade gezählt, maximale Länge von Pfad in Windows beträgt dort 247
                - darüber hinaus lässt sich Dateiname in Datei-Explorer auch nicht erweitern, also ist das sicher die maximale Länge
            - wenn Beschreibung 75 Zeichen lang ist + alle anderen Teile des Schemas die maximale Länge haben (57 Zeichen) + die feste Länge des CC-Magic-Pfades (92 Zeichen, wenn Nutzername max. 30 Zeichen lang ist) + Buffer für unvorhergesehenes (23 Zeichen) = 247 Zeichen
    - Short Link ID
        - ID vom eigenen Short-Link einfügen
    - Patch-Level

        [The Sims 3/Patch](https://sims.fandom.com/wiki/The_Sims_3/Patch)

        - originaler Patch-Level
        - nicht "funktioniert/getestet mit"
            - ist nicht sinnvoll weil der immer 1.69 sein wird, wenn ich es selbst teste
            - ist auch nicht sinnvoll, wenn explizit steht, dass er beispielsweise unter 1.67/1.69 getestet wurde und original von 1.63 ist
                - es ist wahrscheinlicher, dass wenn Probleme meinerseits auftreten, dass dadurch kommt und die beim testen der Mod-Entwickler nur nicht aufgefallen sind
            - also nur den originalen Patch-Level eintragen!
        - Beispiel: p163
    - Datum an dem Mod installiert/getestet wurde
        - Format: 27.04.2020 → 27Apr20
        - wenn Probleme: zuletzt installierte Mods sind am wahrscheinlichsten die Fehlerquelle, auch wenn sie alle Tests nach der Installation bestanden haben
        - spart dann wiederum wahrscheinlich mehr Zeit beim Fehlersuchen
    - Zusätzliche Informationen, Flags, mehre möglich
        - Vorgehen
            - das Zeichen für ein Flag besteht nur aus einem großem Buchstaben
            - nach dem Flag Zeichen können Daten zum Flag folgen
                - die Daten können nur Zeichen von [a-z0-9] haben
                - sonst müsste es für den Dateinamen ersetzt werden oder es könnte nicht zwischen den Flag unterschieden werden
            - werden Flags mit einem Unterstrich voneinander getrennt
            - Daten und Flag werden nicht voneinander getrennt
            - Beispiel: O_P_Dnps9n_Aep11_E
        - O = muss in Overrides-Ordner installiert werden
        - P = muss in Packages-Ordner installiert werden
            - also alles was Store-Content oder andere Packages überschreibt, also Store-Mods
            - alles was durch CC-Magic installiert wird hat eine geringere Priorität als der Mods/Packages-Ordner
        - D = abhängig von anderem Mod, CC, Store oder ähnlichem: Link einfügen
            - Link wird in meinem Link-Shortener hinterlegt, Shortlink-ID davon wird für Link im Dateinamen verwendet
            - Beispiel: Dnps9n
        - A = abhängig von Erweiterungspack oder Accessoirpack: EP, SP Aus Liste auswählen, mehrfachauswahl, vlt mit Icon
            - ep1-ep11t
            - sp1-sp9
        - E = gehört zu den absolut wichtigsten Mods/CC, die immer installiert sein sollten
        - I = es wurde kein Flag gesetzt, nur wenn keine anderen Optionen gewählt sind, existiert nur, damit diese Schema-Teil nicht leer ist, da es sonst zu Ausnahmen im Code kommen müsste
    - Index für doppelte/mehrfache Dateien, wird nur von Programm verwendet
        - Index für mehrere Dateien für die sich ein gleicher Name ergibt
        - Index wird genutzt, damit Datei einzigartig ist
        - Index startet bei 2, bei der ersten doppelten Datei und wird für jede weitere um 1 erhöht
        - Index wird nicht angegeben, wenn die Datei nur einmal existiert

## **Ideen für V2**

- neue umbenannte Dateien werden automatisch nach CC-Magic kopiert und CC-Magic wird gestartet
    - über Downloads-Ordner, **nicht** über CC-Magic Content Ordner
    - sonst werden keine Duplikate abgefangen
- Automatische Arbeitsweisen für Einsortieren der Dateien?
    - Override Mods automatisch nach Overrides-Ordner verschieben?
    - Welten automatisch mit Launcher installieren?
    - Grundstücke, Familien, Saved-Sims für CAS automatisch einsortieren

## Erklärung: neuen weiteren Bestandteil zum Dateinamen-Schema hinzufügen

- **Wichtiges Problem, muss vorher bedacht werden:** neuer Bestandteil für Dateiname = mehr Zeichen im Dateinamen; Zeichenanzahl in Pfad ist von Windows begrenzt
    - die Pfad-Länge von Windows ist auf 247 Zeichen begrenzt, alles darüber hinaus wird (beim manuellen umbenennen durch den Explorer) nicht in den Dateinamen eingetragen
    - diese maximalen 247 Zeichen wurden im Konzept für das Shema berücksichtigt
    - jeder Bestandteil hat eine maximale Zeichenlänge, so dass es unwahrscheinlich ist, dass die 247 Zeichen überschritten werden
    - daher ist der Bestandteil Beschreibung auf 75 Zeichen begrenzt
    - für mehr Details zur Berechnung (warum 75 Zeichen) findest du in der Erklärung des Konzepts weiter oben
    - **bedenke vorher:**
        1. wie viel Zeichen nimmt der neue Bestandteil maximal in Anspruch
        2. ziehe diesen maximalen Zeichen von den maximalen 75 Zeichen der Beschreibung ab
            - Anleitung, maximale Zeichen von Beschreibung anpassen
                - src/Filename_Shema_Description.php, Zeile 10
                - passe die Zahl an
                - **WICHTIG: die Zahl darf nicht höher als 75 sein**

                ```php
                # max amount of character the discription can contain
                private const max_description_length = 75;
                ```

1. lege eine neue Klasse in `src/` an
2. Klassenname: `Filename_Shema_Neuer_Bestandteil`
3. Klasse muss das Interface `I_Filename_Shema` einbinden
4. Klasse muss `abstract` sein
5. Hinterlege die neue Klasse in der `src/Main.php`
    - Anleitung
        - erweitere das Array `shema_order_global`
        - es beinhaltet alle Shema-Klassen-Namen und deren Reihenfolge in der sie aufgerufen werden
        - **WICHTIG: der Name der im Array steht muss auch der Klassenname sein, ohne "Filename_Shema_"**

        ```php
        public const shema_order_global = [
            0 => "Categorie",
            1 => "Description",
            2 => "Link",
            3 => "Patch_Level",
            4 => "Installation_Date",
            5 => "Flag"
        		// hier der Name des neuen Bestandteils
        		// Format: Index für Reihenfolge => Name Bestandteil
        		// WICHTIG: der Name muss auch der Klassenname sein, ohne "Filename_Shema_"
        		6 => "Neuer_Bestandteil"

          ];
        ```

6. orientiere dich an den anderen Klassen und deren Methoden
    - `Filename_Shema_Description` ist ein leicht verständliches Beispiel
7. schreibe Kommentare zu jeder Methode
8. halte dich an die Clean-Code Prinzipien
9. schreibe PHP-Unit-Tests für jede Methode, orientiere dich dabei an bestehenden Unit-Test-Klassen
    - `tests/Filename_Shema_Description_Test.php` ist ein leicht verständliches Beispiel
    - eigene Anleitung zu PHP Unit

        [PHP Unit](https://www.notion.so/PHP-Unit-c0b266704c4248a09ab8d48cc5670e20)
