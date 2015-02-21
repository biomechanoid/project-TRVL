<?php

namespace Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseGallery
 *
 * @ORM\Table(name="BaseGallery")
 * @ORM\MappedSuperClass
 * @ORM\HasLifecycleCallbacks
 */
class BaseGallery
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="context", type="string", length=64)
     */
    private $context;

    /**
     * @var string
     *
     * @ORM\Column(name="default_format", type="string", length=255)
     */
    private $defaultFormat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        // Add your code here
    }
}
