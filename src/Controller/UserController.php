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
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use OpenApi\Annotations as OA;


class UserController extends AbstractFOSRestController{
   
    /**
     * @OA\Get(
     *      tags={"User"},
     *      path="/api/users",
     *      description="Return all the users you created",
     *      security={"bearer"},
     *      @OA\Response(
     *         response=200,
     *         description="List of users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="There is no user to show",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",type="string", example="There is no user to show for the moment.")
     *          ),
     *      ),
     * )
     * @Get(
     *     path = "/api/users",
     *     name = "users_client_get",
     * )
     * @View
     */
    public function getUsersClient()
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findByClient($this->getUser());
        if (!$users)
        {
            throw new HttpException(404, 'No clients can be found!');
        }
        return $users;
    }
    
    /**
     * @OA\Get(
     *      tags={"User"},
     *      path="/api/user/{idUser}",
     *      description="Return the user whoom id is defined in parameter",
     *      security={"bearer"},
     *      @OA\Parameter(
     *          name="idUser",
     *          in="path",
     *          description="Id of the user wanted",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="User's informations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="This user doesn't exist",
     *          @OA\JsonContent(
     *              @OA\Property(property="message",type="string", example="Can't find a user with this id.")
     *          ),
     *      ),
     * )
     * @Get(
     *     path = "/api/user/{idUser}",
     *     name = "user_client_show",
     *     requirements = {"idUser"="\d+"}
     * )
     * @View
     */
    public function showUserClient($idUser)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findById($idUser);
        if (!$user)
        {
            throw new HttpException(404, "This user doesn't exists !");
        }
        //Check if current client owns the user he wants to delete
        if($user[0]->getClient()->getId() !== $this->getUser()->getId())
        {
            throw new HttpException(403, "You can only get users you own.");
        }
        return $user;
    }
    
    /**
     * @OA\Post(
     *      tags={"User"},
     *      path="/api/user/add",
     *      description="Create a new user with datas submit",
     *      security={"bearer"},
     *      @OA\RequestBody(
     *          required=true, 
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(type="string", property="email"),
     *              @OA\Property(type="string", property="password"),
     *          )
     *      ),
     *      @OA\Response(
     *         response=201,
     *         description="User created",
     *      ),
     * )
     * @Post(
     *      path="/api/user/add",
     *      name="user_add")
     * @View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function addUser(User $user,ValidatorInterface $validator)
    {
        $userSubmited = new User();
        //White spaces seems to not be an error to NotBlank
        $userSubmited->setEmail($user->getEmail());
        $userSubmited->setPassword($user->getPassword());
        $userSubmited->setAdress($user->getAdress());
        $userSubmited->setBirthDate($user->getBirthDate());
        $userSubmited->setClient($this->getUser());
        $errors = $validator->validate($userSubmited);
        if (count($errors) > 0) {
            $message = 'The JSON sent contains invalid data. Here are the error(s) you need to correct : ';
            foreach ($errors as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new HttpException(400, $message);
        }  
        $em = $this->getDoctrine()->getManager();
        $em->persist($userSubmited);
        //$em->flush();
        return new JsonResponse(['Information' => 'User created with success'], 201);
    }
    
    /**
     * @OA\Delete(
     *     tags={"User"},
     *     path="/api/user/delete/{idUser}",
     *     summary="Deletes a user with given id",
     *     security={"bearer"},
     *     @OA\Parameter(
     *         name="idUser",
     *         in="path",
     *         description="User id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     * @OA\Response(
     *         response=204,
     *         description="User deleted with success",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="You are not allowed to delete a user you didn't added",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *     ),
     * )
     * @Delete(
     *          path="/api/user/delete/{idUser}",
     *          name="user_delete")
     */
    public function deleteUser($idUser)
    {
        /*  Always true because path parameters are string   
        if (gettype($idUser) != "integer")
        {
            throw new HttpException(400, "Id must be an integer");
        }*/
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('App:User')->find($idUser);
        if ($user)
        {
            //Check if current client owns the user he wants to delete
            if($user->getClient()->getId() == $this->getUser()->getId())
            {
                $em->remove($user);
                //$em->flush(); 
                return new JsonResponse(['Information' => 'User deleted with success'], 201);
            }
            throw new HttpException(403, "You can only delete users you own.");
        }
        throw new HttpException(404, "This user doesn't exists !");
    }
    
}
