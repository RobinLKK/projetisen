#ifndef SOLVER_H
#define SOLVER_H

#include <stdio.h>

#define MAX_SIZE 16

typedef struct { int x, y, steps, prev; } State;
typedef struct { int x, y; } Coord;

// Recherche de chemin (BFS) : retourne 1 si solution, 0 sinon
int bfs(int N, int grid[MAX_SIZE][MAX_SIZE], const char* rule, int ruleParam, int* out_steps, Coord* path, int* out_path_len, int* out_nb_solutions);

// Lance le solveur sur un flux d'entrée/sortie (ex : fichier ou stdin/stdout)
void lancer_solveur(FILE* in, FILE* out);
#endif // SOLVER_H