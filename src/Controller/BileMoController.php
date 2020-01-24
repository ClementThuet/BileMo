<?php
namespace App\Controller;

use App\Entity\MobilePhone;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     *     path = "/mobiles",
     *     name = "mobile_show_all"
     * )
     * @Rest\View
     */
    public function showMobiles()
    {
        $mobiles = $this->getDoctrine()->getRepository('App:MobilePhone')->findAll();
        
        /*$data = $this->get('serializer')->serialize($mobiles,'json');
        
        $response = new Response($data);
        $response->headers->set('Content-Type','application/json');*/
        //dd($mobiles);
        return $mobiles;
    }
    
    /**
     * @Rest\Get(
     *     path = "/mobile/{idMobile}",
     *     name = "mobile_show",
     *     requirements = {"idMobile"="\d+"}
     * )
     * @Rest\View
     */
    public function showMobile()
    {
        //dd($idMobile);
        //$mobile= $this->getDoctrine()->getRepository('App:MobilePhone')->findOneById($idMobile);
        //dd($mobile);
        $mobile = new MobilePhone();
        $mobile->setModelName('Test');
        //$mobile1=$serializer->serialize($mobile,'json');
       // dd($mobile1);
        return $mobile;
    }
    
    /**
     * @Get(
     *     path = "/user/{idUser}",
     *     name = "user_show",
     *     requirements = {"idUser"="\d+"}
     * )
     */
    public function showUser($idUser)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findOneById($idUser);
        
        $data = $this->get('serializer')->serialize($user,'json');
        
        $response = new Response($data);
        $response->headers->set('Content-Type','application/json');
        
        return $response;
    }
    
    /**
     * @Get(
     *     path = "/users",
     *     name = "user_show_all"
     * )
     */
    public function showUsers()
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();
        
        $data = $this->get('serializer')->serialize($users,'json');
        
        $response = new Response($data);
        $response->headers->set('Content-Type','application/json');
        
        return $response;
    }
    
    /**
     * @Rest\Post(
     *      path="/user/add",
     *      name="user_add")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function addUser(User $user)
    {
       
        
        $em = $this->getDoctrine()->getManager();
        $dateNow = new \DateTime('now');
        $user->setRegisteredAt($dateNow);
        $em->persist($user);
        $em->flush();
        $view =  $this->routeRedirectView('user_show',['idUser' => $user->getId()],201);
        return $this->handleView($view);    
               
        
    }
}
