# <p align="center"> IPL Stats API </p>
#### <p align="center">Making access to IPL statistics easier with api calls :grinning:</p>
[![IPL Stats](https://i.ibb.co/G2yFqsJ/ipl-1.png)](https://iplt20-stats.herokuapp.com)

## Whys
<p>To get the statistics of all players in Indian Premier League. As needed such data for one of the project and there was no suitable api found for the purpose,
so decided to create one, and as it was created, shared too, if required by anybody. The data is updated after each match.
The api is developed by scraping data from official website of https://www.iplt20.com, and is latest by the statistics available there.
The data is https://www.iplt20.com property and all rights reserved with them.</p>

<p>Currently the api is useful primarily for only getting a player's data from all seasons combined.
And there are innumerous other stuffs possible to be done. But as the data belongs to the concerned authority,
and it may or may not be adequate to access it without proper permissions and consent.
Still, if you know more of the law and if it's alright to be so, contributions are welcomed to make it bigger.</p>

**You can visualize the api in action here: https://iplt20-stats.herokuapp.com**
(Please be patient for first load time, lazy dyno :zzz: needs some time to wake up :wink:).

You can read docs and try the api here: https://documenter.getpostman.com/view/10557860/TzJsedV4

## Run locally/ Contribute

Follow these steps to run the code locally:
1. Clone this repository.
2. Run `composer install`
3. Run `yarn install`
4. Create a file called **.env.local** at the root of the project
5. Add these environment variables in .env.local:
   * `APP_ENV=dev`
   * `DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"`
    Replace your database credentials here. [Reference](https://symfony.com/doc/current/the-fast-track/en/8-doctrine.html)
6. Run these commands in terminal:
   * `php bin/console make:migration`
   * `php bin/console doctrine:migrations:migrate` If you get any error in some query while running the command. Manually comment out that query in migrations folder. This will setup the local database with all tables.
7. Run `symfony serve -d`
8. Run `yarn watch`
9. The project will start running on the local server.

## Docs :: [Postman](https://documenter.getpostman.com/view/10557860/TzJsedV4)

Provides the list of squads with their name and id.

### Squads List
https://iplt20-stats.herokuapp.com/api/squads-list

#### REQUEST
**Method:** 'GET'

**No params required for the request**

#### RESPONSE
**Json array of objects**

Key | Value
------------ | -------------
id | Squad-id
name | Squad-name

### Squad Details
http://iplt20-stats.herokuapp.com/api/squad-details/{id}

#### Request
**Method:** 'GET'

**The squad-id is passed in the url**

#### Response
**Json object with squad details and array of players in the squad**

Key | Value
------------ | -------------
squad | Object with squad details.
players | Array of player objects.

### Player Details
http://iplt20-stats.herokuapp.com/api/player-details/{id}

#### Request
**Method:** 'GET'

**The player-id is passed in the url**

#### Response
**Json object with player details**

Key | Value
------------ | -------------
player_id | Player-id
player_name | Player-name
team_id | Team-id
image_url | Player image url
matches | Total number of matches played
not_outs | Total number of times player remained not out
runs | Total number of runs scored
highest_score | Highest career score in one inning
batting_average | Batting average (runs scored per wicket)
strike_rate | Strike rate (runs scored per 100 ball)
hundreds | Total Hundreds scored
fifties | Total Fifties scored
sixes | Total Sixes hit
catches | Total catches taken
overs | Total overs bowled
wickets | Total wickets taken
bowling_average | Bowling average (runs conceded per wicket)
economy | Bowling economy (runs conceded per over)
four_wickets | Total four wickets haul

### Players List
http://iplt20-stats.herokuapp.com/api/all-players-list

#### Request
**Method:** 'POST'

**Parameters are passed as Json Object in the body.**

**Note: No parameter is mandatory, and will take default value if not defined.**

Param | Value acceptable | Default Value | Details  
------------ | ------------- | ------------- | -------------
**start_range** | Integer value | 0 | This is taken as the offset value for the total result.
**data_count** | Integer value | 25 | This is the number of results requested. Maximum possible value is 25. It will be taken as 25 automatically if requested more than it. If number of results found/remained are less than `data_count` with respect to `start_range`, lesser data count of results will be sent as response.
**sort_attr** | "matches" \| "not_outs" \| "runs" \| "hundreds" \| "fifties" \| "sixes" \| "catches" \| "overs" \| "wickets" \| "four_wickets" \| "highest" \| "batting_average" \| "bowling_average" \| "strike_rate" \| "economy" | null | The parameter with which the data is desired to be sorted by.
**order** | "asc" \| "desc" | desc | `asc` means ascending order and `desc` means descending order with respect to `sort_attr`

#### Response
**Json array of objects with player details as described above in player details.**
