# Git - Commands (German)


# Repository aus der URL holen:

### Repository kopieren mit Historie (kopiert samt Hauptordner):

```
git clone url.git
```

### Repository kopieren ohne Historie (kopiert nur Inhalt):

```
git pull url.git
```


# Repository neu anlegen:

### Eingabe ändern git>:

```
prompt git$g
```

### Repository erstellen:

```
git init
```


# Dateien im Repository hinzufügen / löschen / umbenennen:

### Datei hinzufügen:

```
git add dateiname
```
```
git commit -m "commit message"
```

### Alle Dateien hinzufügen (-u nur geänderte):

```
git add -a
```
```
git commit -m "commit messaqe"
```

oder

```
git commit -a -m "commit message"
```

### Datei löschen (-r Ordner):

```
git rm dateiname
```
```
git commit -m "commit messaqe"
```

### Datei umbenennen:

```
git mv dateiname neuername
```
```
git commit -m "commit message"
```


# Repository URL hinzufügen:

### Repository hinzufügen:

```
git remote add origin url.git
```

### Gebe alle Repositories aus:

```
git remote -v
```

### Entferne Repository:

```
git remote remove origin
```

### Benenne Repository um:

```
git remote rename origin neworigin
```


# Pushen:

### Auf den Master Branch (URL origin) puschen:

```
git push origin master
```


# Pullen:

### Änderungen (URL origin) pullen:

```
git pull origin
```

### Aus den Master Branch (URL origin) pullen:

```
git pull origin master
```


# Branches erstellen / löschen / ausgeben / wechseln:

### Branch erstellen:

```
git branch name
```

### Branch löschen:

```
git branch -d
```

### Alle Branches ausgeben:

```
git branch -a
```

### Alle Remote Branches ausgeben:

```
git branch -r
```

### Branch wechseln:

```
git checkout name
```

### Branch erstellen und wechseln:

```
git checkout -b name
```


# Tags (lokaler Stand) erstellen:

```
git tag name
```


# Remote Branche herunterladen (URL origin):
(Änderungen sehen ohne diese zu übernehmen)

```
git fetch origin
```


# Rebase (Commit Historie von Branches anwenden):

```
git rebase -i --onto master remote/master
```


# Stash (Sicherung vom Stand) erstellen:

```
git stash push -m "stash message"
```


### Stash Sicherung holen:

```
git stash pop
```

--

# Git - Commands (English)


# Get repository from the URL:

### Copy repository with history (copied with main folder):

```
git clone url.git
```

### Copy repository without history (copies content only):

```
git pull url.git
```


# Rebuild the repository

### Change input git>:

```
prompt git$g
```

### Create repository:

```
git init
```


Add / delete / rename files in the repository:

### Add file:

```
git add filename
```
```
git commit -m "commit message"
```

### Add all files (-u only changed):

```
git add -a
```
```
git commit -m "commit messaqe"
```

or

```
git commit -a -m "commit message"
```

### Delete file (-r folder):

```
git rm filename
```
```
git commit -m "commit messaqe"
```

### Rename file:

```
git mv filename new name
```
```
git commit -m "commit message"
```


# Add repository URL:

### Add repository:

```
git remote add origin original.git
```

### Output all repositories:

```
git remote -v
```

### Remove repository:

```
git remote remove origin
```

### Rename repository:

```
git remote rename origin neworigin
```


# Pushing

### Push on the master branch (URL origin):

```
git push origin master
```


# Pulling:

### Pull changes (URL origin):

```
git pull origin
```

### Pull from the master branch (URL origin):

```
git pull origin master
```


Create / delete / output / change branches:

### Create branch:

```
git branch name
```

### Delete branch:

```
git branch -d
```

### Output all branches:

```
git branch -a
```

### Output all remote branches:

```
git branch -r
```

### Branch change:

```
git checkout name
```

### Create and change branch:

```
git checkout -b name
```


Create tags (local state):

```
git tag name
```


Download Remote Industry (URL origin):
(See changes without accepting them)

```
git fetch origin
```


# Rebase (Applying Branches commit history):

```
git rebase -i --onto master remote/master
```


# Create a stash:

```
git stash push -m "stash message"
```


### Get a stash backup:

```
git stash pop
```

