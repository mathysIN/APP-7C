# Code source de la composante informatique

## Répartition des ressources

Le contenu est réparti en 1 dossiers

- `api` - Implémentation de l'application en PHP

> Un dossier `.cache` est également créé par les scripts. Il est utilisé pour stocker les fichiers temporaires de l'application, un exécutable de **TailwindCSS**.

## Execution

Le site se génère et s'exécute à l'aide des scripts "run" fournis. Il est nécessaire d'installer **PHP** (et donc d'avoir le CLI `php`) pour exécuter l'application.

- **Linux/MacOS** - Faites `sh run.sh` pour lancer l'application.

Pour intéragir avec la base de donnée, vous devez préparer le fichier de variables d'enviromnent `.env`, qui sont utilisées dans le fichier `api/utils/db.php`

Egalement, sur certaines machines, le driver mysql-php n'est installé, il est possible de l'installer avec cette commande :

```bash
curl -L https://gist.githubusercontent.com/GitHub30/2d51bfa327a6eddbde33b77214511584/raw/install_pdo_mysql.gh-codespaces.sh | bash
```


