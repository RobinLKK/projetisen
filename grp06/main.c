#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "concepteurs.h"
#include "solver.h" 

int main(int argc, char* argv[]) {
    if (argc < 2) {
        fprintf(stderr, "Usage: %s [generer|resoudre]\n", argv[0]);
        return 1;
    }

    if (strcmp(argv[1], "generer") == 0) {
        generer_niveau();
    }
    else if (strcmp(argv[1], "resoudre") == 0) {
        lancer_solveur(stdin, stdout);
    }
    else {
        fprintf(stderr, "Argument inconnu : %s\n", argv[1]);
        return 1;
    }
    return 0;
}