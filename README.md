# Real-Time Multiplayer Quiz Game with PHP Sockets and Admin Backend

This project is a real-time multiplayer quiz game built using PHP sockets. It allows multiple players to connect and compete in a quiz, where the player with the highest score wins. <br/>The game features:<br/>

Real-time gameplay: Players receive questions simultaneously, with live scoring based on their answers.<br/>
Multiplayer functionality: Powered by PHP sockets, enabling real-time communication between players and the server.<br/>
Point system: The player who answers correctly and accumulates the highest score wins.<br/>
Admin backend: An additional admin panel to manage game users, track player performance, and control game settings.<br/>

## 1- Create and import the database:
## 2- Create `app.local.php` file in the `configs` folder:
```
<?php

return [
    'APP_ENV'=> 'dev',
    'DB_HOST' => '',
    'DB_NAME' => '',
    'DB_USER' => '',
    'DB_PASSWORD' => '',
    'HOSTNAME' =>'localhost:8080'//for creating game URL in websocket server
];

```

## 3- run commands:
```
php Server.php
php -S localhost:8080 (same as HOSTNAME) -t public
```

# Technologies Used:
-PHP<br/>
-JavaScript<br/>
-Twig<br/>
-Less<br/>
-Ratchet (WebSockets)<br/>
-PHPMailer<br/>
-Composer<br/>
-MicroFramework<br/>

## Summary : 
** The entire admin section is functional: **
Add, edit, and delete questions, answers, and users<br/>
Create a game, add players, and assign their colors<br/>
Create a game link<br/>
Send emails to players<br/>
Dynamic game lobby<br/>



## Installation Guide:: 
To start the server:<br/>
Mac / Linux : php Server.php<br/>
Windows : php .\Server.php<br/>

Here are the credentials to log in as admin:<br/>
Username: AudHep<br/>
Password: aqwzsx
<br/>
The administrator can access the admin section by clicking on their username and selecting "Admin."<br/>
They can choose which page to navigate to, and the side panel provides easy navigation between sections.<br/>
The "+" button in the top right corner allows adding an item.<br/>
Operations allow modifying or deleting an item.<br/>
Input fields are validated to prevent invalid data.<br/>
To add a question, add it like a user. To add answers, click the "+" button next to the question label in the table.<br/>
You can view answers by clicking "View Answers."<br/>

Both users and admins can update their credentials by clicking on their username and selecting "Profile."<br/>

Note: A regular user cannot access the admin section.<br/>
<br/>
## Creating a Game

Any user can create a game by clicking on "Play."
A user account is required to play, so if the user is not logged in, they will be redirected to the login page to sign in or register.<br/>
Once logged in and after clicking "Play," the user will be redirected to the game creation page where they can enter player usernames with autocomplete. Each player is assigned a unique color.<br/>
The game supports 2 to 6 players.<br/>
After clicking "Create," an email will be sent to each user specified.<br/>
For testing purposes, an email has been set up for the user "Gabin" (gamereceipteur@gmail.com), and the game URL will appear in the console.<br/>
The email contains the game link.<br/>
<br/>
## The Game:

When players click the link they received via email, they will join the game.<br/>
The page updates dynamically without refreshing, thanks to Ratchet.<br/>
Only the player whose turn it is can play, by clicking the "Play" button.<br/>
A modal with the levels will appear on all screens. The player selects a level and answers the question.<br/>
The interaction with the question takes place in the modal, which then displays whether the answer is correct or incorrect.<br/>
The modal automatically disappears 3 seconds after answering, and the next player takes their turn.<br/>
The player’s piece moves forward or backward based on the correctness of their answer.<br/>

Known Issues:<br/>
-Winner function is not yet implemented.<br/>
-The same question may appear multiple times.<br/>
-Usernames are not removed from the autocomplete during game creation (double input event after adding a new username field).<br/>
-Only supports multiple-choice questions (MCQ).<br/>
