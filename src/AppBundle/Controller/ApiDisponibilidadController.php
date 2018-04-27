<?php
namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiDisponibilidadController extends FOSRestController implements ClassResourceInterface
{

  /**
    * @FOS\Get("/disponibilidades", name="get_disponibilidades", options={ "method_prefix" = false }))
    */
  public function cgetDisponibilidadesAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $disponibilidad = $this->getDoctrine()->getRepository('AppBundle:Disponibilidad');
    $orderedcolumn = array("d.id", "d.fecha", "d.horaInicio", "d.horaFin");

    $datos = $disponibilidad->createQueryBuilder('d')
    ->andWhere('d.id like :searchvalue OR d.fecha like :searchvalue OR d.horaInicio like :searchvalue OR d.horaFin like :searchvalue')
    ->orderBy($orderedcolumn[$request->query->get('order')['0']["column"]], $request->query->get('order')['0']["dir"])
    ->setFirstResult($request->query->get('start'))
    ->setMaxResults($request->query->get('length'))
    ->setParameter('searchvalue', '%'.$request->query->get('search')["value"].'%')
    ->getQuery()
    ->getResult();

    $cantidaddatos = $disponibilidad->createQueryBuilder('d')
    ->select('COUNT(d.id)')
    ->andWhere('d.id like :searchvalue OR d.fecha like :searchvalue OR d.horaInicio like :searchvalue OR d.horaFin like :searchvalue')
    ->orderBy($orderedcolumn[$request->query->get('order')['0']["column"]], $request->query->get('order')['0']["dir"])
    ->setParameter('searchvalue', '%'.$request->query->get('search')["value"].'%')
    ->getQuery()
    ->getSingleScalarResult();

    $valores = array();
    foreach($datos as $dato){
      $valores[] = array('id' => $dato->getId(),
        'fecha' => $dato->getFecha()->format('Y-m-d'),
        'hora_inicio' => $dato->getHoraInicio()->format('H:i:s'),
        'hora_fin' => $dato->getHoraFin()->format('H:i:s'),
      );
    }

    $respuesta = array(
      'draw' => $request->query->get('draw'),
      'recordsTotal' => $cantidaddatos,
      'recordsFiltered' => $cantidaddatos,
      'data' => $valores,
    );

    $view = $this->view($respuesta, 200);
    return $this->handleView($view);
  }
}
