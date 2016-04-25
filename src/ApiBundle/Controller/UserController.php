<?php 
namespace ApiBundle\Controller\V1;  

use FOS\RestBundle\Controller\FOSRestController;  
use FOS\RestBundle\Controller\Annotations as Rest;  

class UserController extends FOSRestController  
{     
/**       
* @return array       
* @Rest\Get("/users/{id}")       
* @Rest\View       
*/    
public function getUserAction($id)     
{      
     $em = $this->getDoctrine()->getManager();
     $user = $em->getRepository('AppBundle:User')->find($id);

     return array('user' => $user);
   }
   
/**
 * GET Route annotation.
 * @return array
 * @Rest\Get("/users/get.{_format}")
 * @Rest\View
 */
public function getUsersAction()
{
    $em = $this->getDoctrine()->getManager();
    $users = $em->getRepository('AppBundle:User')->findAll();

    return array('users' => $users);
}   
}