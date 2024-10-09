Questions ouvertes :

1. Comment ferais-tu pour gérer des appels API multiples en JavaScript,
   tout en t'assurant que les résultats arrivent dans l'ordre et sont traités efficacement ?

1) Il me semble que "await" va permettre un traitement dans l'ordre résultat et qu'il ne passera pas au résultat suivant tant que le premier résultat n'a pas été reçu, ce qui va éviter des erreurs d'absence de résultat.

2. Comment ferais-tu pour gérer une relation complexe entre trois entités
   (ex. : utilisateurs, projets, et tâches) dans Laravel, avec des requêtes performantes
   et un modèle de données flexible ?

2) je commencerai pas définir les relations entre les tables (ex: un utilisateur peut avoir plusieur projets, etc). Après je créerai les tables avec leurs clés primaires et étrangères pour faire le lien entre les tables.

3. Comment ferais-tu pour assurer la scalabilité d'une base de données MySQL
   utilisée par une application qui doit gérer un volume de trafic en forte croissance ?

3) J'essayerai d'optimiser au maximum les requêtes et les tables. Pour éviter que certaines requêtes soient trop lentes.
