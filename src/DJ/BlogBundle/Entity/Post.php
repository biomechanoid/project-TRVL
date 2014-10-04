<?php

namespace DJ\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Locale\Stub\StubLocale;
use Application\Sonata\MediaBundle\Entity\Media as Media ;


/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Post
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
     * @var integer
     * @ORM\ManyToOne(targetEntity="DJ\UserBundle\Entity\User", inversedBy="post")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var text
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
    * @var string
    * @ORM\Column(name="slug", type="string", length=255, unique=true)
    *
    */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var integer
     *
     * @ORM\Column(name="node", type="integer")
     */
    private $node=0;

    /**
     * @var string
     * @ORM\Column(name="soft_delete", type="boolean")
     *
     */
    private $softDelete;

    /**
    * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", orphanRemoval=true)
    */
    protected $comments;

    /**
     * @ORM\ManyToOne( targetEntity="Category", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET null")
     *
     */
    protected $category;

    /**
     *
     * @ORM\OneToMany(targetEntity="PostAsset", mappedBy="postid", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $postAssets;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\ManytoOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $media;

    /**
     * @var string
     * @ORM\Column(name="display", type="boolean")
     *
     */
    private $display = false;

    /**
    * @var string
    * @ORM\Column(name="locale", type="string", length=10)
    *
    */
    private $locale = 'en';

    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
    	$this->softDelete = false;
    	$this->postAssets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
    	return $this->slug;
    }

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
     * Set categoryId
     *
     * @param integer $categoryId
     * @return Post
     */
    public function setCategoryId($categoryId)
    {

        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set author
     *
     * @param integer $author
     * @return Post
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return integer
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = trim(strtolower( str_replace(' ', '-', $slug)));

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Post
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Post
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
     * Add comments
     *
     * @param \DJ\BlogBundle\Entity\Comment $comments
     * @return Post
     */
    public function addComment(\DJ\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \DJ\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\DJ\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set softDelete
     *
     * @param boolean $softDelete
     * @return Post
     */
    public function setSoftDelete($softDelete)
    {
        $this->softDelete = $softDelete;

        return $this;
    }

    /**
     * Get softDelete
     *
     * @return boolean
     */
    public function getSoftDelete()
    {
        return $this->softDelete;
    }

    /**
     * Set node
     *
     * @param integer $node
     * @return Post
     */
    public function setNode($node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return integer
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set category
     *
     * @param \DJ\BlogBundle\Entity\Category $category
     * @return Post
     */
    public function setCategory(\DJ\BlogBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \DJ\BlogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add postAssets
     *
     * @param \DJ\BlogBundle\Entity\PostAsset $postAssets
     * @return Post
     */
    public function addPostAsset(\DJ\BlogBundle\Entity\PostAsset $postAssets)
    {
        $this->postAssets[] = $postAssets;

        return $this;
    }

    /**
     * Remove postAssets
     *
     * @param \DJ\BlogBundle\Entity\PostAsset $postAssets
     */
    public function removePostAsset(\DJ\BlogBundle\Entity\PostAsset $postAssets)
    {
        $this->postAssets->removeElement($postAssets);
    }

    /**
     * Get postAssets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostAssets()
    {
        return $this->postAssets;
    }

    /**
     * Set display
     *
     * @param boolean $display
     * @return Post
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return boolean
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return Post
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Add images
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $images
     * @return Post
     */
    public function addImage(\Application\Sonata\MediaBundle\Entity\Media $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $images
     */
    public function removeImage(\Application\Sonata\MediaBundle\Entity\Media $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set images
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $images
     * @return Post
     */
    public function setImages(\Application\Sonata\MediaBundle\Entity\Media $images = null)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return Post
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }
}
