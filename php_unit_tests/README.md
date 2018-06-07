# Unit Tests

Unit Tests.

### Version
1.0.0


AuthorizationsTest, ConfigurationsTest & ContentConfigurationsTest:

Prüfungen ob alle neu hinzugekommenen Rechte, Einstellungen und Inhalte im System in den Datenbank-Scripten sind.

Geprüft wird hierbei, ob es ein Eintrag in den DB-Scripts (Ordner: db/scripts/version) gibt.
Beispiel Rechte: INSERT INTO authorization (`Key`, `Comment`, `Class`, `ID_AuthorizationType`) 
VALUES ( 'admin.recht', 'Recht-Titel', NULL, '1');

Hierbei hat der Admin automatisch auch die neuen Rechte.


InstalldbTest:

Ein Unit Test welches prüft, ob ein DB-Install Script fehlerfrei durchgelaufen ist.
Als Ergebnis des Unit Tests wird wiedergegeben, wenn der Test nicht fehlerfrei durchgelaufen ist und ausgeben, 
bei welchem Script (Dateinname, Zeile, SQL-Script) er abbricht.


LanguagesTest:

Es wird geprüft ob die Anzahl der Übersetzungsschlüssel übereinstimmen und ob diese in der selben Zeile sind.
Ebenfalls wird geprüft ob alle Übersetzungsschlüssel auch in allen Sprachen vorhanden sind.
Es wird ebenfalls auf Duplikate geprüft und gegebenfalls die Sprachdatei und die Zeile ausgegeben.


ModelsTest (Doctrine):

Ein Unit Test, in dem geprüft wird, ob die generierten Models aus Doctrine (ORM) mit 
der aktuellen Datenbank-Struktur übereinstimmen.

1. Wenn Models, die keine Tabelle haben, da sind, kommt die Meldung, dass der Inhalt des Ordners 
"system/application/models/generated" geleert werden soll und die Models neugeneriert werden müssen.

2. Wenn Models fehlen, kommt die Meldung, dass die Models neugeneriert werden sollen.

3. Wenn der Inhalt der Models sich von der Datenbank-Struktur unterscheidet, kommt die 
Meldung zum Neugenerieren der Models und die Zeilen, die nicht übereinstimmen, werden ausgeben.

Der Test legt eine komplette Kopie der neu generierten Models im "tmp"-Verzeichnis an 
und prüft auf die bestehenden Models. Nach dem Abschluß der Prüfung, wird das neu erstellte 
Verzeichnis samt der generierten Models gelöscht.






