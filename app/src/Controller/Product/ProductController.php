<?php

namespace App\Controller\Product;

use App\Controller\ApiController;
use App\Entity\Weather\City;
use App\Service\Product\ProductManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends ApiController
{
    /**
     * @Route("/product/{city}", name="product.get_by_city_weather", methods={"GET"})
     * @ParamConverter("city", options={"mapping": {"city": "city"}})
     *
     * @param City $city
     *
     * @return Response
     */
    public function listByCityWeatherAction(City $city, ProductManager $productManager): Response
    {
        $recommendationsByCity = $productManager->getRecommendationByCity($city);



        return $this->success($recommendationsByCity, Response::HTTP_OK, [], [
            'groups' => ['recommendation'],
        ]);
    }
}
