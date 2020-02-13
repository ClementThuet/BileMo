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
use App\Entity\User;

class BileMoController extends AbstractFOSRestController{
   
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return new Response(
            '<html><body>Welcome to BileMo\'s API !</body></html>');
    }
    
    
    /**
     * @Get(
     *     path = "/api/mobiles",
     *     name = "mobiles_show"
     * )
     * @View
     */
    public function showMobiles()
    {
        $mobiles = $this->getDoctrine()->getRepository('App:MobilePhone')->findAll();
        return $mobiles;
    }
    
    /**
     * @Get(
     *     path = "/api/mobile/{idMobile}",
     *     name = "mobile_show",
     *     requirements = {"idMobile"="\d+"}
     * )
     * @View
     */
    public function showMobile($idMobile)
    {
        $mobile= $this->getDoctrine()->getRepository('App:MobilePhone')->findOneById($idMobile);
        return $mobile;
    }
    
    /**
     * @Get(
     *     path = "/api/users",
     *     name = "users_client_show",
     *     requirements = {"idClient"="\d+"}
     * )
     * @View
     */
    public function showUsersClient()
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findUsersByClient($this->getUser()->getId());
        return $users;
    }
    
    /**
     * @Get(
     *     path = "/api/user/{idUser}",
     *     name = "user_client_show",
     *     requirements = {"idUser"="\d+"}
     * )
     * @View
     */
    public function showUserClient($idUser)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findUserById($idUser,$this->getUser()->getId());
        return $user;
    }
    
    /**
     * @Post(
     *      path="/api/user/add",
     *      name="user_add")
     * @View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function addUser(User $user)
    {
        
        $em = $this->getDoctrine()->getManager();
        $user->setClient($this->getUser());
        //dd($user);
        $em->persist($user);
        $em->flush();
        $view =  $this->routeRedirectView('user_client_show',['idUser' => $user->getId()],201);
        return $this->handleView($view);    
    }
    
    /**
     * @Delete(
     *          path="/api/user/delete/{idUser}",
     *          name="user_delete")
     */
    public function deleteUser($idUser)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('App:User')->find($idUser);
        if ($user)
        {
            //Check if current client own the user he wants to delete
            if($user->getClient()->getId() == $this->getUser()->getId())
            {
                $em->remove($user);
                $em->flush(); 
                return $this->view(null, Response::HTTP_NO_CONTENT);
            }
            return $this->view(null, Response::HTTP_UNAUTHORIZED );
        }
        return $this->view(null, Response::HTTP_NOT_FOUND);
    }
    
}
