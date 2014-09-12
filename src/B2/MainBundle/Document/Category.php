<?php
namespace B2\MainBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

/**
 * @MongoDB\Document(collection="category")
 */
class Category
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $categoryName;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $category;

    /**
     * @MongoDB\Field(type="collection")
     * @Assert\NotBlank()
     */
    protected $sub;




    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    public function getCategoryName()
    {
        return $this->categoryName;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setSub($sub)
    {
        $this->sub = $sub;
    }

    public function getSub()
    {
        return $this->sub;
    }




}