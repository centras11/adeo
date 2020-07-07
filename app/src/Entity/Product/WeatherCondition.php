<?php

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntityInterface;
use App\Entity\Traits\IdTrait;

/**
 * @ORM\Table(
 *     name="product_weather_condition",
 * )
 * @ORM\Entity()
 */
class WeatherCondition implements BaseEntityInterface
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @param string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
}
