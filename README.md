# EZFacility-League-Web-Scraper
PHP class to scrape EZFacility EZLeague information pages since they refuse to update their archaic technology and build an API

### How To Use

```php
<?php
require('ezleague-scrape.php');
$ezLeague = new EzLeagueScrape;
$ezLeague->setLeaguePage('http://ezleagues.ezfacility.com/leagues/*****/*****.aspx?framed=1');
$ezLeagueData = json_encode($ezLeague->getAllLeagueInformation());
```
