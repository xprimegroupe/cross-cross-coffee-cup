<?php

namespace XP\C4\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="XP\C4\Entity\Repository\CupRepository")
 * @ORM\Table(name="cup")
 */
class Cup
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer") 
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $twitter;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $img_big;

    /**
     * @var datetime $created_at
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getTwitter()
    {
        return $this->twitter;
    }

    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
        return $this;
    }

    public function getImgBig()
    {
        return $this->img_big;
    }

    public function setImgBig($img_big)
    {
        $this->img_big = $img_big;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getImageFile()
    {
        if (strpos($this->getImgBig(), 'data:image/png;base64,') !== 0)
        {
            return false;
        }
        $img = str_replace('data:image/png;base64,', '', $this->getImgBig());
        $img = str_replace(' ', '+', $img);

        $file = sys_get_temp_dir () . '/' . md5(time() . rand(0, 999999)) . '.png';
        if (file_put_contents($file, base64_decode($img)) === false)
        {
            return false;
        }
        return $file;
    }

}