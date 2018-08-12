<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fuacet
 *
 * @ORM\Table(name="fuacet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FuacetRepository")
 */
class Fuacet
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=100, unique=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="query", type="string", length=100, nullable=true)
     */
    private $query;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="string", length=500, nullable=true)
     */
    private $info;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="until", type="datetime")
     */
    private $until;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ban_until", type="datetime")
     */
    private $banUntil;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_debt", type="boolean")
     */
    private $isDebt;


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
     * Set url
     *
     * @param string $url
     *
     * @return Fuacet
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set query
     *
     * @param string $query
     *
     * @return Fuacet
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return Fuacet
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Fuacet
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set until
     *
     * @param \DateTime $until
     *
     * @return Fuacet
     */
    public function setUntil($until)
    {
        $this->until = $until;

        return $this;
    }

    /**
     * Get until
     *
     * @return \DateTime
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Fuacet
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return Fuacet
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set banUntil
     *
     * @param \DateTime $banUntil
     *
     * @return Fuacet
     */
    public function setBanUntil($banUntil)
    {
        $this->banUntil = $banUntil;

        return $this;
    }

    /**
     * Get banUntil
     *
     * @return \DateTime
     */
    public function getBanUntil()
    {
        return $this->banUntil;
    }

    /**
     * Set isDebt
     *
     * @param boolean $isDebt
     *
     * @return Fuacet
     */
    public function setIsDebt($isDebt)
    {
        $this->isDebt = $isDebt;

        return $this;
    }

    /**
     * Get isDebt
     *
     * @return bool
     */
    public function getIsDebt()
    {
        return $this->isDebt;
    }
}

