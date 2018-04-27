<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Disponibilidad;


class LoadDisponibilidades implements FixtureInterface
{
  /**
   * Load data fixtures with the passed EntityManager
   *
   * @param ObjectManager $manager
   */

  public function load(ObjectManager $manager)
  {
    $horaIni = new \DateTime();
    $horaF = new \DateTime();
    $horaF = $horaF->modify("+20 minutes");
    for ($i=0; $i < 50; $i++) {
      $fecha = new \DateTime();
      $disponibilidad = new Disponibilidad();
      $disponibilidad->setFecha($fecha);
      $disponibilidad->setHoraInicio($horaIni);
      $disponibilidad->setHoraFin($horaF);
      $horaIni = $horaIni->modify("+30 minutes");
      $horaF = $horaF->modify("+30 minutes");
      $manager->persist($disponibilidad);
      $manager->flush();
    }
  }

}
