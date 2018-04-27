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
    $numcolumn = ($request->query->get('column') != '' && $request->query->get('column') <= 3) ? $request->query->get('column') : 0;

    if ( $numcolumn == 1 ) {
      $whereconditions = 'd.fecha like :searchValue';
    } elseif ($numcolumn == 2) {
      $whereconditions = 'd.horaInicio like :searchValue';
    } elseif ($numcolumn == 3) {
      $whereconditions = 'd.horaFin like :searchValue';
    } else {
      $whereconditions = 'd.id like :searchValue';
    }


    $datos = $disponibilidad->createQueryBuilder('d')
    ->andWhere($whereconditions)
    ->orderBy($orderedcolumn[$numcolumn], $request->query->get('dir'))
    ->setFirstResult($request->query->get('start'))
    ->setMaxResults($request->query->get('lenght'))
    ->setParameter('searchValue', '%'.$request->query->get('search')["value"].'%')
    ->getQuery()
    ->getResult();

    $cantidaddatos = $disponibilidad->createQueryBuilder('d')
    ->select('COUNT(d.id)')
    ->andWhere($whereconditions)
    ->orderBy($orderedcolumn[$numcolumn], $request->query->get('dir'))
    ->setParameter('searchValue', '%'.$request->query->get('search')["value"].'%')
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
