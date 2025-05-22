
----------------------------Principe du jeu--------------------------------

Le joueur doit traverser une grille (par exemple 5×5) de la case de départ à une case d’arrivée, en suivant des règles logiques imposées par les valeurs des cases.

Exemple de règle logique :
Tu peux te déplacer vers une case si sa valeur est un multiple de 3, ça peut être le niveau 1 par exemple.

Ou : tu peux avancer seulement si la valeur est strictement supérieure à celle de la case précédente.

Ou encore : la case suivante doit avoir une différence de 1 avec la précédente (comme un jeu de suite logique).

Les règles peuvent être fixes ou choisies en début de partie.


--------------------------Résumé des tâches à faire-------------------------------------

-Affichage de la grille (avec des valeurs connues, pas générées aléatoirement pour garder le déterminisme).

-Déplacement avec les touches Z/Q/S/D ou flèches.

-Vérification des règles à chaque déplacement (Arrêter le jeu si le mouvement est invalide,le joueur a perdu)

- Les deux concepteurs de niveaux (manuel et automatique) 
- Un solveur
- Liaison avec l'interface web
