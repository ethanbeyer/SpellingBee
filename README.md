# README

## Idea

Upon the assignment of a code project, my mind first went to a thing I use every day: the NYT Spelling Bee game.

Why?

It's deceptively simple.

One could simply pick 7 letters and define that one of them must be present in every word entered, but each day's puzzle has some cunning to it. The choice of what 7 letters to use, and which of them is required changes the amount of possible words dramatically, which means there's a degree of statistical analysis or gamesmanship require.

I want to codify that.

## Objectives

- Back End
    - Dictionary
        - Import
        - Drop the words that are unneeded
            - any words with a length < 4
            - any words with a letter count > 7
    - Helper Functions/Classes

- Front End
    - on load, get game state
        - 7 letters, 1 required
