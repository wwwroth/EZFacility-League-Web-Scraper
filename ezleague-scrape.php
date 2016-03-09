<?php

require_once ('simple-html-dom.php');

class EzLeagueScrape {

    private $targetLeaguePage;
    private $targetLeaguePageContents;

    public function setLeaguePage($url)
    {
        $this->targetLeaguePage = $url;
        $this->targetLeaguePageContents = file_get_html($this->targetLeaguePage);

    }

    public function getAllLeagueInformation()
    {
        return [
            'standings' => $this->getStandings(),
            'schedule' => $this->getSchedule(),
            'league-details' => $this->getLeagueDetails()
        ];
    }

    public function getStandings()
    {
        $standingsTable = $this->targetLeaguePageContents->find('table[id=ctl00_C_Standings_GridView1]', 0);
        $i = 0;
        $headers = [];
        $teamsAndValues = [];
        foreach($standingsTable->find('tr') as $row) {
            if ($i == 0) {
                $x = 0;
                while ($x <= 100) {
                    $contents = $row->find('th', $x)->plaintext;
                    if ($contents) {
                        $headers[] = preg_replace("/&#?[a-z0-9]+;/i","", $contents);
                    } else break;
                    $x++;
                }
                $columns = count($headers);
                $columnsTrimmed = array_filter($headers);
                $columnsTrimmed[0] = "Name";
            } else {
                $y = 0;
                while ($y<$columns) {
                    $teamAndValues[$columnsTrimmed[$y]] = $this->sanitizeData($row->find('td', $y)->plaintext);
                    $y++;
                }
                $teamsAndValues[] = $teamAndValues;
            }
            $i++;
        }
        return $teamsAndValues;
    }

    public function getSchedule()
    {
        $scheduleTable = $this->targetLeaguePageContents->find('table[id=ctl00_C_Schedule1_GridView1]', 0);
        $i = 0;
        $headers = [];
        $schedule = [];
        foreach ($scheduleTable->find('tr') as $row) {
            if ($i==0) {
                $x = 0;
                while ($x <= 100) {
                    $contents = $row->find('th', $x)->plaintext;
                    if ($contents) {
                        $headers[] = preg_replace("/&#?[a-z0-9]+;/i","", $contents);
                    } else break;
                    $x++;
                }
                $columns = count($headers);
                $columnsTrimmed = array_filter($headers);
            } else {
                $y = 0;
                while ($y<$columns) {
                    $scheduleRow[$columnsTrimmed[$y]] = $this->sanitizeData($row->find('td', $y)->plaintext);
                    $y++;
                }
                $schedule[] = $scheduleRow;
            }
            $i++;
        }
        return $schedule;
    }

    public function getLeagueDetails()
    {
        $leagueDetailsTable = $this->targetLeaguePageContents->find('table[id=Table13]', 0);
        $i = 0;
        $rows = array();
        foreach ($leagueDetailsTable->find('tr') as $row) {
            if ($i > 0) {
                $row = array($this->sanitizeData($row->find('td', 0)->plaintext) => $this->sanitizeData($row->find('td', 1)->plaintext));
                $rows[] = $row;
            }
            $i++;
        }
        return $rows;
    }

    private function sanitizeData($input)
    {
        $sanitized = str_replace(':', '', $input);
        $sanitized = str_replace('&nbsp;', ' ', $sanitized);
        return trim($sanitized);
    }
}

#$ezLeague = new EzLeagueScrape;
#$ezLeague->setLeaguePage('http://ezleagues.ezfacility.com/leagues/262203/Kickball-Thursdays-Spring-%2716.aspx?framed=1');
#$ezLeague->setLeaguePage('http://ezleagues.ezfacility.com/leagues/257737/Indoor-Soccer-SUNDAYS-(All-American-Indoor).aspx');
#$ezLeague->setLeaguePage('http://ezleagues.ezfacility.com/leagues/262030/Sunday-Softball-Spring-%2716-(Morristown).aspx?framed=1');\

#var_dump($ezLeague->getAllLeagueInformation());
