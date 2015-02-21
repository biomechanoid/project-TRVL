<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediaMedia
 *
 * @ORM\Table(name="media__media")
 * @ORM\Entity
 */
class MediaMedia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
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
     * @ORM\Column(name="length", type="decimal", precision=10, scale=0, nullable=true)
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
    private $contentSize;

    /**
     * @var string
     *
     * @ORM\Column(name="copyright", type="string", length=255, nullable=true)
     */
    private $copyright;

    /**
     * @var string
     *
     * @ORM\Column(name="author_name", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;


}
