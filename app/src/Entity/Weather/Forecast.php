<?php

namespace App\Entity\Weather;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntityInterface;
use App\Entity\Traits\IdTrait;

/**
 * @ORM\Table(
 *     name="weather_forecast",
 *     indexes = {
 *          @ORM\Index(name="forecast_time_city_index", columns={"forecas_time", "city"}),
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Weather\ForecastRepository")
 */
class Forecast implements BaseEntityInterface
{
    use IdTrait;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="forecast_time_utc", type="datetime", nullable=true)
     */
    private $forecastTimeUtc;

    /**
     * @var string
     *
     * @ORM\Column(name="condition_code", type="string", length=20. nulable=true)
     */
    private $conditionCode;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Weather\City", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
     */
    private $city;

    /**
     * @return DateTime
     */
    public function getForecastTimeUtc(): DateTime
    {
        return $this->forecastTimeUtc;
    }

    /**
     * @param DateTime $forecastTimeUtc
     */
    public function setForecastTimeUtc(DateTime $forecastTimeUtc): void
    {
        $this->forecastTimeUtc = $forecastTimeUtc;
    }

    /**
     * @return string
     */
    public function getConditionCode(): string
    {
        return $this->conditionCode;
    }

    /**
     * @param string $conditionCode
     */
    public function setConditionCode(string $conditionCode): void
    {
        $this->conditionCode = $conditionCode;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city): void
    {
        $this->city = $city;
    }
}
