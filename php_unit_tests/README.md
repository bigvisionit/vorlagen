# Unit Tests

Unit Tests.

### Version
1.0.0

AuthorizationsTest, ConfigurationsTest & ContentConfigurationsTest:

Checks if all newly added rights, settings and contents in the system are in the database scripts.

The system checks whether there is an entry in the DB scripts (folder: db/scripts/version).
Example Rights: INSERT INTO authorization (`Key`, `Comment`, `Class`, `ID_AuthorizationType`) 
VALUES ('admin.right','Right title', NULL,'1');

The admin automatically has the new rights.


InstalldbTest:

A unit test which checks whether a DB install script has run without errors.
The result of the unit test is displayed if the test did not run without errors and output, 
at which script (file name, line, SQL script) it terminates.


LanguagesTest:

The system checks whether the number of translation keys matches and whether they are in the same line.
The system also checks whether all translation keys are available in all languages.
The system also checks for duplicates and, if necessary, outputs the language file and the line.


ModelsTest (Doctrine):

A unit test that checks whether the generated models from Doctrine (ORM) with 
of the current database structure.

1. if models who do not have a table are there, the message that the contents of the folder 
"system/application/models/generated" should be emptied and the models need to be regenerated.

2. if models are missing, a message appears that the models should be regenerated.

3. if the content of the models differs from the database structure, the 
A message to regenerate the models and the lines that do not match are displayed.

The test creates a complete copy of the newly generated models in the "tmp" directory 
and checks on the existing models. After completion of the check, the newly created 
directory together with the generated models.

_

Deutsche Version:

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






