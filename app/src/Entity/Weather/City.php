<?php

namespace App\Entity\Weather;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntityInterface;
use App\Entity\Traits\IdTrait;

/**
 * @ORM\Table(
 *     name="weather_city",
 *     indexes = {
 *          @ORM\Index(name="data_visit_session_visitor_id_index", columns={"session_visitor_id"}),
 *          @ORM\Index(name="data_visit_url_id_index", columns={"url_id"}),
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Data\VisitRepository")
 */
class City implements BaseEntityInterface
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=100)
     */
    private $city;

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }
}
