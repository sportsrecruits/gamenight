# Game Night

An application that will track who participated in what games, who won what, how many points they get, and then displays a leaderboard for the current game of competition.  

* When someone visits the app for the first time in the day it creates a leaderboard for that day. 
* Users can login and create account using Google Auth
* Logged in users (uses Google Auth only) are able to create games by choosing a game (provided in a seeder file with the code).
* Users can view the games in progress, and go into a game to see more details.  
* Anyone else using the app can join the game by joining a team. The first person to join a team gets that team named after them.  
* Users can always create a new team of their own. There is no limit to how many teams can be part of one game (as some games are team based like foosball and others like card games are played as an individual (which here is a team of one). 
* Anyone participating in a game can select a winning team. Approval from at least two participants of the winner closes the game and awards the points to the winner(s)
