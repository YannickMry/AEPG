![AEPG](docs/images/logo-aepg.png)

AEPG est une application permettant aux étudiants de l'association des étudiants pénalistes de grenoble de pouvoir se faire connaitre ainsi que de faire vivre l'application en y introduisant des articles sur le sujet du droit pénal.

## Installation

## Récupérer les sources du projet
Pensez à `fork` le projet.
```
git clone https://github.com/<your-username>/<repo-name>
```

## Pré-requis
* PHP >= 7.2.5
* Extensions PHP :
    * ctype
    * iconv
    * json
    * xml
    * intl
    * mbstring
* Composer
* MySQL/MariaDB

## Installer les dépendances
Dans un premier temps, positionnez vous dans le dossier du projet :
```
cd <repo-name>
```

Exectuer la commande suivante
```
make install
```

## Environnements
Pour faire fonctionner le projet sur votre machine, pensez à configurer les différents environnements.

## Initialiser les base de données
En commençant par l'environnement `test`
```
make database-test
```

Puis l'environnement `dev`:
```
make database-dev
```

Si vous le souhaitez, vous pouvez aussi injecter des fixtures en plus de mettre en place la base de données :

Pour l'environnement `test`
```
make fixtures-test
```

Puis l'environnement `dev`:
```
make fixtures-dev
```

## Lancer le serveur en local
Il est nécessaire d'avoir installé le [binaire de symfony](https://symfony.com/download).
```
symfony serve
```

## Gestion des ressources externes (css, js)
Compilez une seule fois les fichiers en environnement de développement :
```
npm run dev
```

Activez la compilation automatique :
```
npm run watch
```

Compilez les fichiers pour la production :
```
npm run build
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)