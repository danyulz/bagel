#include <ics46/factory/DynamicFactory.hpp>
#include "MazeG.hpp"
#include "Maze.hpp"
#include <random>
#include <vector>
#include <stdio.h>  /* printf, scanf, puts, NULL */
#include <stdlib.h> /* srand, rand */
#include <time.h>   /* time */

ICS46_DYNAMIC_FACTORY_REGISTER(MazeGenerator, MazeG, "Maze Generator (Required)")

void recursion(Maze &maze, int x, int y, std::vector<std::vector<bool>> &cells)
{

    if (cells[x][y])
    {
        return;
    }

    if (!(y > 0 && (y - 1 >= 0 && !cells[x][y - 1])))
    {
        return;
    }
    if (!(y < maze.getHeight() - 1 && ((y + 1 <= maze.getHeight() - 1) && !cells[x][y + 1])))
    {
        return;
    }

    if (!(x > 0 && (x - 1 >= 0 && !cells[x - 1][y])))
    {
        return;
    }
    if (!(x < maze.getWidth() - 1 && ((x + 1 <= maze.getWidth() - 1) && !cells[x + 1][y])))
    {
        return;
    }
    else
    {

        srand(time(NULL));

        std::vector<Direction> possibleDirections = {Direction::up, Direction::down, Direction::left, Direction::right};

        for (int i = 0; i < 4; i++)
        {
            int random = rand() % (4 - i);

            if (possibleDirections[random] == Direction::up)
            {
                recursion(maze, x, y - 1, cells);
            }
            else if (possibleDirections[random] == Direction::down)
            {
                recursion(maze, x, y + 1, cells);
            }
            else if (possibleDirections[random] == Direction::left)
            {
                recursion(maze, x - 1, y, cells);
            }
            else if (possibleDirections[random] == Direction::right)
            {
                recursion(maze, x + 1, y, cells);
            }

            possibleDirections.erase(random);
        }
    }
}

void MazeG::generateMaze(Maze &maze)
{
    maze.addAllWalls();
    std::vector<std::vector<bool>> cells(maze.getHeight(), std::vector<bool>(maze.getWidth(), false));
    recursion(maze, 0, 0, cells);
}
message.txt 3 KB