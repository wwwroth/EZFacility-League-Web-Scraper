# EZFacility-League-Web-Scraper
PHP class to scrape EZFacility EZLeague information pages since they refuse to update their archaic technology and build an API

### How To Use

```php
<?php
require('ezleague-scrape.php');
$ezLeague = new FuckEzLeague;
$ezLeague->setLeaguePage('http://ezleagues.ezfacility.com/leagues/*****/*****.aspx?framed=1');
$ezLeagueData = json_encode($ezLeague->getAllLeagueInformation());
```

#### Notes
This is poor code- I know. I wrote it as quick as possible to help out a friend who is building a club sports page and needed a solution to avoid EzFacility's way of using iFrames to terribly designed unresponsive pages.

EzFacility, if you're reading this, build a RESTful API for existing and new customers. Regardless of what data is in the database you don't want to expose (was told this on the phone) if you write the queries responsibly you wdon't have to worry about that.
