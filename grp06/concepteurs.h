#ifndef CONCEPTEURS_H
#define CONCEPTEURS_H

// Génère et affiche un niveau au format JSON
void generer_niveau(void);

// Fonctions utilitaires (optionnel, à exposer si besoin ailleurs)
int gen_value_on_path(const char* rule, int prev, int param);
int gen_trap_value(const char* rule, int param);

#endif // CONCEPTEURS_H