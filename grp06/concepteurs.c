#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <math.h>
#include <string.h>
#include "regles.h"

#define MIN_SIZE 4
#define MAX_SIZE 16

int gen_value_on_path(const char* rule, int prev, int param) {
    if (strcmp(rule, "paire") == 0)
        return 2 * (1 + rand() % 25);
    if (strcmp(rule, "multiple") == 0)
        return param * (2 + rand() % 10);
    if (strcmp(rule, "premier") == 0) {
        int n = 2 + rand() % 50;
        while (!is_prime(n)) n++;
        return n;
    }
    if (strcmp(rule, "meme_parite") == 0)
        return prev + 2 * (1 + rand() % 10);
    if (strcmp(rule, "multiple_precedent") == 0)
        return prev * (2 + rand() % 3);
    if (strcmp(rule, "superieur") == 0 || strcmp(rule, "croissant") == 0)
        return prev + 1 + rand() % 5;
    if (strcmp(rule, "inferieur") == 0)
        return prev - 1 - rand() % 5;
    if (strcmp(rule, "somme_chiffres") == 0) {
        int n = 10 + rand() % 90;
        while (sum_digits(n) != param) n++;
        return n;
    }
    if (strcmp(rule, "somme_chiffres_paire") == 0) {
        int n = 2 + rand() % 98;
        while (sum_digits(n) % 2 != 0) n++;
        return n;
    }
    if (strcmp(rule, "impair") == 0)
        return 1 + 2 * (rand() % 25);
    return 0;
}

int gen_trap_value(const char* rule, int param) {
    if (strcmp(rule, "paire") == 0)
        return 1 + 2 * (rand() % 25);
    if (strcmp(rule, "multiple") == 0) {
        int n;
        do { n = 1 + rand() % 50; } while (n % param == 0);
        return n;
    }
    if (strcmp(rule, "premier") == 0) {
        int n, tries = 0;
        do { n = 4 + rand() % 50; tries++; } while (is_prime(n) && tries < 100);
        if (is_prime(n)) n = 4; // fallback si pas trouvé
        return n;
    }
    if (strcmp(rule, "meme_parite") == 0) {
        // Génère une valeur de parité différente de la précédente
        int n = 1 + 2 * (rand() % 25); // impair
        if (param % 2 == 1) n++; // si la précédente était impaire, prend pair
        return n;
    }
    if (strcmp(rule, "multiple_precedent") == 0)
        return (rand() % 20) + 1; // Pas multiple du précédent
    if (strcmp(rule, "superieur") == 0 || strcmp(rule, "croissant") == 0)
        return (rand() % 20) - 20; // Plus petit ou égal
    if (strcmp(rule, "inferieur") == 0)
        return (rand() % 20) + 100; // Plus grand ou égal
    if (strcmp(rule, "somme_chiffres") == 0) {
        int n;
        do { n = 10 + rand() % 90; } while (sum_digits(n) == param);
        return n;
    }
    if (strcmp(rule, "somme_chiffres_paire") == 0) {
        int n;
        do { n = 2 + rand() % 98; } while (sum_digits(n) % 2 == 0);
        return n;
    }
    if (strcmp(rule, "impair") == 0)
        return 2 * (1 + rand() % 25);
    return 0;
}

void generer_niveau(void) {
    srand(time(NULL));
    int N = MIN_SIZE + rand() % (MAX_SIZE - MIN_SIZE + 1);

    const char* rules[] = {
        "paire", "multiple", "premier", "meme_parite", "multiple_precedent",
        "superieur", "inferieur", "croissant", "somme_chiffres", "somme_chiffres_paire", "impair"
    };
    int rule_idx = rand() % (sizeof(rules) / sizeof(rules[0]));
    const char* rule = rules[rule_idx];
    int param = 2 + rand() % 5; // Pour "multiple" et "somme_chiffres"

    if (strcmp(rule, "somme_chiffres") == 0)
        param = 5 + rand() % 15;

    int path[2 * MAX_SIZE][2] = { 0 };
    int x = 0, y = 0, path_len = 0;
    path[path_len][0] = x; path[path_len][1] = y; path_len++;
    while (x < N - 1 || y < N - 1) {
        if (x < N - 1 && (y == N - 1 || rand() % 2)) x++;
        else y++;
        path[path_len][0] = x; path[path_len][1] = y; path_len++;
    }

    int grid[MAX_SIZE][MAX_SIZE] = { 0 };
    int prev = 2;
    for (int i = 0; i < path_len; i++) {
        int px = path[i][0], py = path[i][1];
        int val = gen_value_on_path(rule, prev, param);
        grid[py][px] = val;
        prev = val;
    }
    for (int i = 0; i < N; i++)
        for (int j = 0; j < N; j++)
            if (grid[i][j] == 0)
                grid[i][j] = gen_trap_value(rule, param);

    // Affichage JSON
    printf("{\n");
    printf("  \"grid\": [\n");
    for (int i = 0; i < N; i++) {
        printf("    [");
        for (int j = 0; j < N; j++) {
            printf("%d", grid[i][j]);
            if (j < N - 1) printf(", ");
        }
        printf("]%s\n", i < N - 1 ? "," : "");
    }
    printf("  ],\n");
    printf("  \"rule\": \"%s\"", rule);
    if (strcmp(rule, "multiple") == 0 || strcmp(rule, "somme_chiffres") == 0)
        printf(",\n  \"ruleParam\": %d", param);
    printf(",\n  \"ruleText\": \"Deplacement uniquement sur ");
    if (strcmp(rule, "paire") == 0) printf("un nombre pair");
    else if (strcmp(rule, "multiple") == 0) printf("un multiple de %d", param);
    else if (strcmp(rule, "premier") == 0) printf("un nombre premier");
    else if (strcmp(rule, "meme_parite") == 0) printf("une case de meme parite que la precedente");
    else if (strcmp(rule, "multiple_precedent") == 0) printf("une case multiple de la precedente");
    else if (strcmp(rule, "superieur") == 0 || strcmp(rule, "croissant") == 0) printf("une case superieure a la precedente");
    else if (strcmp(rule, "inferieur") == 0) printf("une case inferieure a la precedente");
    else if (strcmp(rule, "somme_chiffres") == 0) printf("une case dont la somme des chiffres est %d", param);
    else if (strcmp(rule, "somme_chiffres_paire") == 0) printf("une case dont la somme des chiffres est paire");
    else if (strcmp(rule, "impair") == 0) printf("un nombre impair");
    printf("\"\n");
    printf("}\n");
}

/*int main() {
    srand(time(NULL));
    int N = MIN_SIZE + rand() % (MAX_SIZE - MIN_SIZE + 1);

    const char* rules[] = {
        "paire", "multiple", "premier", "meme_parite", "multiple_precedent",
        "superieur", "inferieur", "croissant", "somme_chiffres", "somme_chiffres_paire", "impair"
    };
    int rule_idx = rand() % (sizeof(rules) / sizeof(rules[0]));
    const char* rule = rules[rule_idx];
    int param = 2 + rand() % 5; // Pour "multiple" et "somme_chiffres"

    if (strcmp(rule, "somme_chiffres") == 0)
        param = 5 + rand() % 15;

    int path[2 * MAX_SIZE][2] = { 0 };
    int x = 0, y = 0, path_len = 0;
    path[path_len][0] = x; path[path_len][1] = y; path_len++;
    while (x < N - 1 || y < N - 1) {
        if (x < N - 1 && (y == N - 1 || rand() % 2)) x++;
        else y++;
        path[path_len][0] = x; path[path_len][1] = y; path_len++;
    }

    int grid[MAX_SIZE][MAX_SIZE] = { 0 };
    int prev = 2;
    for (int i = 0; i < path_len; i++) {
        int px = path[i][0], py = path[i][1];
        int val = gen_value_on_path(rule, prev, param);
        grid[py][px] = val;
        prev = val;
    }
    for (int i = 0; i < N; i++)
        for (int j = 0; j < N; j++)
            if (grid[i][j] == 0)
                grid[i][j] = gen_trap_value(rule, param);

    // Affichage JSON
    printf("{\n");
    printf("  \"grid\": [\n");
    for (int i = 0; i < N; i++) {
        printf("    [");
        for (int j = 0; j < N; j++) {
            printf("%d", grid[i][j]);
            if (j < N - 1) printf(", ");
        }
        printf("]%s\n", i < N - 1 ? "," : "");
    }
    printf("  ],\n");
    printf("  \"rule\": \"%s\"", rule);
    if (strcmp(rule, "multiple") == 0 || strcmp(rule, "somme_chiffres") == 0)
        printf(",\n  \"ruleParam\": %d", param);
    printf(",\n  \"ruleText\": \"Deplacement uniquement sur ");
    if (strcmp(rule, "paire") == 0) printf("un nombre pair");
    else if (strcmp(rule, "multiple") == 0) printf("un multiple de %d", param);
    else if (strcmp(rule, "premier") == 0) printf("un nombre premier");
    else if (strcmp(rule, "meme_parite") == 0) printf("une case de meme parite que la precedente");
    else if (strcmp(rule, "multiple_precedent") == 0) printf("une case multiple de la precedente");
    else if (strcmp(rule, "superieur") == 0 || strcmp(rule, "croissant") == 0) printf("une case superieure a la precedente");
    else if (strcmp(rule, "inferieur") == 0) printf("une case inferieure a la precedente");
    else if (strcmp(rule, "somme_chiffres") == 0) printf("une case dont la somme des chiffres est %d", param);
    else if (strcmp(rule, "somme_chiffres_paire") == 0) printf("une case dont la somme des chiffres est paire");
    else if (strcmp(rule, "impair") == 0) printf("un nombre impair");
    printf("\"\n");
    printf("}\n");
    return 0;
}*/