<?php
class Position
{
    private $id;
    private $latitude;
    private $longitude;
    private $datePosition;
    private $imei;
    private $code;

    public function __construct($id, $latitude, $longitude, $datePosition, $imei, $code)
    {
        $this->id = $id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->datePosition = $datePosition;
        $this->imei = $imei;
        $this->code = $code;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getDatePosition()
    {
        return $this->datePosition;
    }

    public function getImei()
    {
        return $this->imei;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function setDatePosition($datePosition)
    {
        $this->datePosition = $datePosition;
    }

    public function setImei($imei)
    {
        $this->imei = $imei;
    }
}
