<?php
namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Components\HttpFoundation\Request;

Class ApiController extends FOSRestController implements ClassResourceInterface
{
  /**
   * @FOS\Get("/prueba", name="get_prueba", options={ "method_prefix" = false}))
   */
   public function cgetPruebaAction()
   {
     $datospersonales = array("edad"=>"46", "ciudad_residencia"=>"Palma", "pais_residencia"=>"España");
     $valores = array("persona" => "Miguel Soler", "datos"=>$datospersonales);
     $view = $this->view($valores, 200);
     return $this->handleView($view);
   }
}
