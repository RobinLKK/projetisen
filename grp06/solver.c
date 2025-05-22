#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include "regles.h"

#define MAX_SIZE 16

typedef struct { int x, y, steps, prev; } State;
typedef struct { int x, y; } Coord;

int dirs[4][2] = { {1,0},{0,1},{-1,0},{0,-1} };

int bfs(int N, int grid[MAX_SIZE][MAX_SIZE], const char* rule, int ruleParam, int* out_steps, Coord* path, int* out_path_len, int* out_nb_solutions) {
    int visited[MAX_SIZE][MAX_SIZE] = { 0 };
    int parent[MAX_SIZE][MAX_SIZE][2];
    memset(parent, -1, sizeof(parent));
    State queue[MAX_SIZE * MAX_SIZE * 4];
    int front = 0, back = 0;
    int min_steps = -1;
    int nb_solutions = 0;

    queue[back++] = (State){ 0, 0, 0, grid[0][0] };
    visited[0][0] = 1;

    while (front < back) {
        State s = queue[front++];
        if (min_steps != -1 && s.steps > min_steps) break;

        if (s.x == N - 1 && s.y == N - 1) {
            if (min_steps == -1) {
                min_steps = s.steps;
                if (out_steps) *out_steps = s.steps;
                int len = s.steps + 1;
                int cx = s.x, cy = s.y;
                for (int i = len - 1; i >= 0; i--) {
                    path[i].x = cx;
                    path[i].y = cy;
                    int px = parent[cy][cx][0], py = parent[cy][cx][1];
                    cx = px; cy = py;
                }
                if (out_path_len) *out_path_len = len;
            }
            nb_solutions++;
            continue;
        }
        for (int d = 0; d < 4; d++) {
            int nx = s.x + dirs[d][0], ny = s.y + dirs[d][1];
            if (nx >= 0 && nx < N && ny >= 0 && ny < N) {
                if (!visited[ny][nx] || (visited[ny][nx] == s.steps + 2)) {
                    if (check_rule(s.prev, grid[ny][nx], rule, ruleParam)) {
                        queue[back++] = (State){ nx, ny, s.steps + 1, grid[ny][nx] };
                        if (!visited[ny][nx]) {
                            parent[ny][nx][0] = s.x;
                            parent[ny][nx][1] = s.y;
                        }
                        visited[ny][nx] = s.steps + 2;
                    }
                }
            }
        }
    }
    if (out_nb_solutions) *out_nb_solutions = nb_solutions;
    return min_steps != -1;
}

void lancer_solveur(FILE* in, FILE* out) {
    int N, ruleParam = 0, steps = 0, path_len = 0, nb_solutions = 0;
    char rule[32];
    int grid[MAX_SIZE][MAX_SIZE];
    Coord path[MAX_SIZE * MAX_SIZE];

    // Lecture depuis le flux in
    if (fscanf_s(in, "%d %31s", &N, rule, (unsigned)sizeof(rule)) != 2) {
        fprintf(out, "{\"error\":\"Format de niveau invalide (entête)\"}\n");
        return;
    }
    if (strcmp(rule, "multiple") == 0 || strcmp(rule, "somme_chiffres") == 0) {
        if (fscanf_s(in, "%d", &ruleParam) != 1) {
            fprintf(out, "{\"error\":\"Paramètre de règle manquant\"}\n");
            return;
        }
    }
    for (int i = 0; i < N; i++)
        for (int j = 0; j < N; j++)
            if (fscanf_s(in, "%d", &grid[i][j]) != 1) {
                fprintf(out, "{\"error\":\"Grille incomplète\"}\n");
                return;
            }

    if (bfs(N, grid, rule, ruleParam, &steps, path, &path_len, &nb_solutions)) {
        fprintf(out, "{\"solvable\":true,\"steps\":%d,\"unique\":%s,\"path\":[", steps, (nb_solutions == 1 ? "true" : "false"));
        for (int i = 0; i < path_len; i++) {
            fprintf(out, "[%d,%d]%s", path[i].x, path[i].y, (i < path_len - 1) ? "," : "");
        }
        fprintf(out, "]}\n");
    }
    else {
        fprintf(out, "{\"solvable\":false}\n");
    }
}
