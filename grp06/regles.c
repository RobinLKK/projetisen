#include <stdio.h>
#include "regles.h"
#include <string.h>
#include <math.h>

int is_prime(int n) {
    if (n < 2) return 0;
    for (int i = 2; i <= sqrt(n); i++)
        if (n % i == 0) return 0;
    return 1;
}

int sum_digits(int n) {
    int sum = 0;
    while (n) { sum += n % 10; n /= 10; }
    return sum;
}
int check_rule(int prev, int next, const char* rule, int ruleParam) {
    if (strcmp(rule, "croissant") == 0) return next > prev;
    if (strcmp(rule, "superieur") == 0) return next > prev;
    if (strcmp(rule, "inferieur") == 0) return next < prev;
    if (strcmp(rule, "multiple") == 0) return next % ruleParam == 0;
    if (strcmp(rule, "paire") == 0) return next % 2 == 0;
    if (strcmp(rule, "impair") == 0) return next % 2 == 1;
    if (strcmp(rule, "meme_parite") == 0) return (next % 2) == (prev % 2);
    if (strcmp(rule, "somme_chiffres_paire") == 0) return sum_digits(next) % 2 == 0;
    if (strcmp(rule, "multiple_precedent") == 0) return prev != 0 && next % prev == 0;
    if (strcmp(rule, "premier") == 0) return is_prime(next);
    if (strcmp(rule, "somme_chiffres") == 0) return sum_digits(next) == ruleParam;
    return 0;
}