<?php
require_once __DIR__ . "/../utils/global_types.php";

class Trame
{
    public $trame;
    public $objectID;
    public $requestType;
    public $sensorType;
    public $sensorId;
    public $sensorValue;
    public $frameNumber;
    public $checksum;
    public $date;

    public function __construct($trame, $objectID, $requestType, $sensorType, $sensorId, $sensorValue, $frameNumber, $checksum, $date)
    {
        $this->trame = $trame;
        $this->objectID = $objectID;
        $this->requestType = $requestType;
        $this->sensorType = $sensorType;
        $this->sensorId = $sensorId;
        $this->sensorValue = intval($sensorValue);
        $this->frameNumber = $frameNumber;
        $this->checksum = $checksum;
        $this->date = $date;
    }

    public static function getTrames($limit = 30)
    {
        global $_ISEP_SENSOR_TEAM;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=$_ISEP_SENSOR_TEAM");
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        $data_tab = str_split($data, 33);

        $trames = array();

        foreach ($data_tab as $frame) {
            if (count($trames) >= $limit) break;
            $trame = Trame::toTrame($frame);
            if ($trame != null) $trames[] = $trame;
        }
        return array_reverse($trames);;
    }

    private static function toTrame($frame)
    {
        if (strlen($frame) == 33) {
            $t = substr($frame, 0, 1);
            $o = substr($frame, 1, 4);
            $r = substr($frame, 5, 1);
            $c = substr($frame, 6, 1);
            $n = substr($frame, 7, 2);
            $v = substr($frame, 9, 4);
            $a = substr($frame, 13, 4);
            $x = substr($frame, 17, 2);
            $year = substr($frame, 19, 4);
            $month = substr($frame, 23, 2);
            $day = substr($frame, 25, 2);
            $hour = substr($frame, 27, 2);
            $min = substr($frame, 29, 2);
            $sec = substr($frame, 31, 2);

            $date = "$year-$month-$day $hour:$min:$sec";

            return new Trame($frame, $o, $r, $c, $n, $v, $a, $x, $date);
        }
        return null;
    }
}
