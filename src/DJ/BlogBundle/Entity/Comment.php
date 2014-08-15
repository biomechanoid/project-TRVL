<?php

namespace DJ\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Comment
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
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="postid", referencedColumnName="id", onDelete="CASCADE")
     */
    private $post;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="DJ\UserBundle\Entity\User", inversedBy="comment")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var text
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
     * @var boolean
     *
     * @ORM\Column(name="display", type="boolean")
     */
    protected $display;

    /**
     * @var text
     *
     * @ORM\Column(name="ip", type="text")
     */
    protected $ip;

	public function __construct() {
		$this->created = new \DateTime('now');
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
     * Set postid
     *
     * @param integer $postid
     * @return Comment
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

    /**
     * Set userid
     *
     * @param integer $userid
     * @return Comment
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comment
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
     * Set created
     *
     * @param \DateTime $created
     * @return Comment
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
     * Set display
     *
     * @param boolean $display
     * @return Comment
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
     * Set ip
     *
     * @param string $ip
     * @return Comment
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set user
     *
     * @param integer $user
     * @return Comment
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set post
     *
     * @param \DJ\BlogBundle\Entity\Post $post
     * @return Comment
     */
    public function setPost(\DJ\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \DJ\BlogBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
