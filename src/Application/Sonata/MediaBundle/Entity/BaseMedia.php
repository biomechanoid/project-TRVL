<?php

namespace Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseMedia
 *
 * @ORM\Table(name="BaseMedia")
 * @ORM\MappedSuperClass
 * @ORM\HasLifecycleCallbacks
 */
class BaseMedia
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=1024, nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="provider_name", type="string", length=255, nullable=false)
     */
    private $providerName;

    /**
     * @var integer
     *
     * @ORM\Column(name="provider_status", type="integer", nullable=false)
     */
    private $providerStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="provider_reference", type="string", length=255, nullable=false)
     */
    private $providerReference;

    /**
     * @var json
     *
     * @ORM\Column(name="provider_metadata", type="json", nullable=true)
     */
    private $providerMetadata;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="length", type="decimal", nullable=true)
     */
    private $length;

    /**
     * @var string
     *
     * @ORM\Column(name="content_type", type="string", length=255, nullable=true)
     */
    private $contentType;

    /**
     * @var integer
     *
     * @ORM\Column(name="content_size", type="integer", nullable=true)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="copyright", type="string", nullable=true)
     */
    private $copyright;

    /**
     * @var string
     *
     * @ORM\Column(name="author_name", type="string", nullable=true)
     */
    private $authorName;

    /**
     * @var string
     *
     * @ORM\Column(name="context", type="string", length=64, nullable=true)
     */
    private $context;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cdn_is_flushable", type="boolean", nullable=true)
     */
    private $cdnIsFlushable;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cdn_flush_at", type="datetime", nullable=true)
     */
    private $cdnFlushAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="cdn_status", type="integer", nullable=true)
     */
    private $cdnStatus;

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
