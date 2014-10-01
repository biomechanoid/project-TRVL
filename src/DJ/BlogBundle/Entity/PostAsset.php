<?php

namespace DJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vlabs\MediaBundle\Annotation\Vlabs;

/**
 * PostAsset
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DJ\BlogBundle\Entity\PostAssetRepository")
 */
class PostAsset
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *  @ORM\ManyToOne(targetEntity="Pool", inversedBy="postAssets")
     *  @ORM\JoinColumn(name="poolid", referencedColumnName="id", nullable=false)
     */
    private $poolid;

    /**
     *  @var VlabsFile
     *
     * @ORM\ManyToOne(targetEntity="Asset", inversedBy="postAssets", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="assetid", referencedColumnName="id", nullable=false)
     *
     * @Vlabs\Media(identifier="asset_entity", upload_dir="files/images")
     * @Assert\Valid()
     */
    private $assetid;

    /**
     *  @ORM\ManyToOne(targetEntity="Post", inversedBy="postAssets")
     *  @ORM\JoinColumn(name="postid", referencedColumnName="id", nullable=false)
     */
    private $postid;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set poolid
     *
     * @param integer $poolid
     * @return PostAsset
     */
    public function setPoolid($poolid)
    {
        $this->poolid = $poolid;

        return $this;
    }

    /**
     * Get poolid
     *
     * @return integer
     */
    public function getPoolid()
    {
        return $this->poolid;
    }

    /**
     * Set assetid
     *
     * @param DJ\BLogBundle\Entity\Asset $assetid
     * @return PostAsset
     */
    public function setAssetid($assetid = null)
    {
        $this->assetid = $assetid;

        return $this;
    }

    /**
     * Get assetid
     *
     * @return DJ\BLogBundle\Entity\Asset
     */
    public function getAssetid()
    {
        return $this->assetid;
    }

    /**
     * Set postid
     *
     * @param integer $postid
     * @return PostAsset
     */
    public function setPostid($postid)
    {
        $this->postid = $postid;

        return $this;
    }

    /**
     * Get postid
     *
     * @return integer
     */
    public function getPostid()
    {
        return $this->postid;
    }
}
