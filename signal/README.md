# Code source de la composante signal

## Répartition des ressources

Le contenu est réparti en 2 dossiers

- `matlab_src` - Implémentation des problèmes sur Matlab
- `files` - Fichiers complémentaires, principalement les fichiers audios utilisés pendant les tests

### Sources Matlab

Comme expliqué précédement, tous les codes sources sont situés dans le dossier `matlab_src`, dossier de référence absolue pour les chemins de fichiers cité ci-dessous.

**Répartition des dossiers**<br/>

Le contenu des sources est réparti en 3 dossiers :

- `libs` - Fonctions utiles au démarrage et aux tests des programmes
- `probleme_[numero]` - Implémentation des différents problèmes
- `probleme_[numero]/local_libs` - Fonctions spécifiques au problème séléctionné

**Execution**<br/>

En utilisant Matlab, executez le programme principal de chaque problème :<br/>
`probleme_[numero]/main.m`

**Tests**<br/>

Presque tout les fonctions fonction ayant une sortie disposent d'un test unitaire. Pour vérifier le bon fonctionnement des fonctions, executez les programmes de tests :<br/>
`probleme_[numero]/local_libs/[nom_fonction]/test_[nom_fonction].m`

Vous pouvez également créer vos propres tests en renseignant des valeurs d'entrées et des valeurs attendues, avec les fonctions `libs/test_code.m` et `libs/test_all_code/M`.

Egalement, certains problèmes disposent de tests pour des problèmes cas d'usages spécifiques. Il est possible de les retrouver dans le dossier :<br/>
`probleme_[num]/tests`