<?php

namespace App\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntityInterface;
use App\Entity\Traits\IdTrait;

/**
 * @ORM\Table(
 *     name="product_product",
 * )
 * @ORM\Entity(repositoryClass="App\Repository\Product\ProductRepository")
 */
class Product implements BaseEntityInterface
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=10)
     */
    private $sku;

    /**
     * @ORM\ManyToMany(targetEntity="WeatherCondition", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="product_to_weather")
     */
    private $weatherConditions;

    public function __construct()
    {
        $this->weatherConditions = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

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
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return ArrayCollection
     */
    public function getWeatherConditions(): ArrayCollection
    {
        return $this->weatherConditions;
    }

    /**
     * @param WeatherCondition $weatherCondition
     */
    public function addWeatherCondition(WeatherCondition $weatherCondition): void
    {
        if ($this->weatherConditions->contains($weatherCondition)) {
            return;
        }

        $this->weatherConditions->add($weatherCondition);
    }

    /**
     * @param WeatherCondition $weatherCondition
     */
    public function removeWeatherCondition(WeatherCondition $weatherCondition): void
    {
        if (!$this->weatherConditions->contains($weatherCondition)) {
            return;
        }

        $this->weatherConditions->removeElement($weatherCondition);
    }
}
