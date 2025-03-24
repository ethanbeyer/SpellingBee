# README

# Technologies Used

- Laravel 12
- PHP 8.4
    - Composer
- MySQL 5.7
- Docker
- HTML
- CSS / Bootstrap 5.3.3
- NPM


## Main Files to Review

1. [Word.php Model](app/Models/Word.php)
2. [`words` Table Migration](database/migrations/2025_03_23_201359_create_words_table.php)
3. [`word` Table Seeder](database/seeders/WordSeeder.php)
3. [Front-End View](resources/views/find-words.blade.php)
4. [Front-End Controller](app/Http/Controllers/WordController.php)

## Dictionary Links

1. https://drive.google.com/file/d/1oGDf1wjWp5RF_X9C7HoedhIWMh5uJs8s/view
2. https://raw.githubusercontent.com/dwyl/english-words/refs/heads/master/words_alpha.txt

## Idea

Upon the assignment of a code project, my mind first went to a thing I use every day: the NYT Spelling Bee game.

Why?

It's deceptively simple.

One could simply pick 7 letters and define that one of them must be present in every word entered, but each day's puzzle has some cunning to it. The choice of what 7 letters to use, and which of them is required changes the amount of possible words dramatically, which means there's a degree of statistical analysis or gamesmanship require.

I want to codify that, and make a tool that helps the "editor" decide upon the 7 letters to include, as well as which of the seven should be Required.

## Objectives

- Back End
    - Dictionary
        - Import
        - Drop the words that are unneeded
            - any words with a length < 4
            - any words with a letter count > 7
            - any words with a letter count > 15
    - Helper Functions/Classes

- Front End
    - on load, get game state
        - 7 letters, 1 required
