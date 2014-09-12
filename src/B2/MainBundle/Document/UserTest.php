<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bishnu
 * Date: 9/6/14
 * Time: 5:32 PM
 * To change this template use File | Settings | File Templates.
 */

namespace B2\MainBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/** @MongoDB\Document(collection="user_test") */
class UserTest {
    /**
     * @MongoDB\Id
     */
    protected  $id;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    public $user;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    public $category;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    public $subcategory;

    /**
     * @MongoDB\Date
     * @Assert\NotBlank()
     */
    public $dateTime;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    public $ip;

    /**
     * @MongoDB\Boolean
     * @Assert\NotBlank()
     */
    public $isTestComplete;



    public function setIsTestComplete($isTestComplete)
    {
        $this->isTestComplete = $isTestComplete;
    }

    public function getIsTestComplete()
    {
        return $this->isTestComplete;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;
    }

    public function getSubcategory()
    {
        return $this->subcategory;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }



}