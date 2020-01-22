<?php
namespace App\Controller;

use App\Entity\MobilePhone;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BileMoController extends Controller{
   
    public function index()
    {
        return new Response(
            '<html><body>Welcome to the homepage, nothink to see for the moment</body></html>');
    }
    
     public function showMobiles()
    {
        $mobiles = $this->getDoctrine()->getRepository('App:MobilePhone')->findAll();
        
        $data = $this->get('serializer')->serialize($mobiles,'json');
        
        $response = new Response($data);
        $response->headers->set('Content-Type','application/json');
        
        return $response;
    }
    
    public function showMobile()
    {
        $mobile = new MobilePhone();
        $mobile->setManufacturer("Samsung");
        $mobile->setModelName("Galaxy S7 Edge");
        
        $data = $this->get('serializer')->serialize($mobile,'json');
        
        $response = new Response($data);
        $response->headers->set('Content-Type','application/json');
        
        return $response;
    }
    
    public function showUser($idUser)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findOneById($idUser);
        
        $data = $this->get('serializer')->serialize($user,'json');
        
        $response = new Response($data);
        $response->headers->set('Content-Type','application/json');
        
        return $response;
    }
    
    public function showUsers()
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();
        
        $data = $this->get('serializer')->serialize($users,'json');
        
        $response = new Response($data);
        $response->headers->set('Content-Type','application/json');
        
        return $response;
    }
    
    public function addUser(Request $request)
    {
        $data = $request->getContent();
       
        //dd($data);
        $user = $this->get('serializer')->deserialize($data,'App\Entity\User','json');
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        
        return new Response('',Response::HTTP_CREATED);
        
    }
}
