<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Disponibilidad
 *
 * @ORM\Table(name="disponibilidad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DisponibilidadRepository")
 */
class Disponibilidad
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_inicio", type="time")
     */
    private $horaInicio;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_fin", type="time")
     */
    private $horaFin;

    /**
     * @ORM\OneToMany(targetEntity="Agenda", mappedBy="disponibilidad")
     */
    protected $disponibilidads;

    public function __construct()
    {
        $this->disponibilidads = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Disponibilidad
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set horaInicio
     *
     * @param \DateTime $horaInicio
     *
     * @return Disponibilidad
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    /**
     * Get horaInicio
     *
     * @return \DateTime
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * Set horaFin
     *
     * @param \DateTime $horaFin
     *
     * @return Disponibilidad
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    /**
     * Get horaFin
     *
     * @return \DateTime
     */
    public function getHoraFin()
    {
        return $this->horaFin;
    }

    /**
     * Add disponibilidad
     *
     * @param \AppBundle\Entity\Agenda $disponibilidad
     *
     * @return Disponibilidad
     */
    public function addDisponibilidad(\AppBundle\Entity\Agenda $disponibilidad)
    {
        $this->disponibilidads[] = $disponibilidad;

        return $this;
    }

    /**
     * Remove disponibilidad
     *
     * @param \AppBundle\Entity\Agenda $disponibilidad
     */
    public function removeDisponibilidad(\AppBundle\Entity\Agenda $disponibilidad)
    {
        $this->disponibilidads->removeElement($disponibilidad);
    }

    /**
     * Get disponibilidads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisponibilidads()
    {
        return $this->disponibilidads;
    }
}
