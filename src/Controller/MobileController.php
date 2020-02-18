<?php
namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Entity\User;
use OpenApi\Annotations as OA;


class MobileController extends AbstractFOSRestController{
   
    /**
     * @OA\Get(
     *      path="/api/mobiles",
     *      tags={"Mobile"},
     *      description="Return all mobiles phones availables",
     *      security={"bearer"},
     *      @OA\Response(
     *         response=200,
     *         description="Mobiles",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/MobilePhone")
     *         ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No mobile phones to show",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",type="string", example="There is no mobile phone to display for the moment.")
     *          ),
     *      ),
     * )
     * @Get(
     *     path = "/api/mobiles",
     *     name = "mobiles_get"
     * )
     * @View
    */
    public function getMobiles()
    {
        $mobiles = $this->getDoctrine()->getRepository('App:MobilePhone')->findAll();
        if (!$mobiles)
        {
            throw new HttpException(404, "No mobiles can be found!");
        }
        return $mobiles;
        
    }
    
    /**
     * @OA\Get(
     *      path="/api/mobile/{idMobile}",
     *      tags={"Mobile"},
     *      description="Return the mobile phone whoom id is defined in parameter",
     *      security={"bearer"},
     *      @OA\Parameter(
     *          name="idMobile",
     *          in="path",
     *          description="Id of the mobile phone wanted",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Mobile's informations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/MobilePhone")
     *         ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="This mobile doesn't exist",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",type="string", example="Can't find a mobile with this id.")
     *          ),
     *      ),
     * )
     * @Get(
     *     path = "/api/mobile/{idMobile}",
     *     name = "mobile_get",
     *     requirements = {"idMobile"="\d+"}
     * )
     * @View
     */
    public function getMobile($idMobile)
    {
        $mobile= $this->getDoctrine()->getRepository('App:MobilePhone')->findOneById($idMobile);
        if (!$mobile)
        {
            throw new HttpException(404, "This mobile doesn't exists !");
        }
        return $mobile;
    }
    
}
