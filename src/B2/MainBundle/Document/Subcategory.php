<?php
namespace B2\MainBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\EmbeddedDocument
 */
class Subcategory
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $subcategoryName;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $subcategory;

    /**
     * @MongoDB\Field(type="boolean")
     * @Assert\NotBlank()
     */
    protected $hasSample;


    public function setSubcategoryName($subcategoryName)
    {
        $this->subcategoryName = $subcategoryName;
    }

    public function getSubcategoryName()
    {
        return $this->subcategoryName;
    }

    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;
    }

    public function getSubcategory()
    {
        return $this->subcategory;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setHasSample($hasSample)
    {
        $this->hasSample = $hasSample;
    }

    public function getHasSample()
    {
        return $this->hasSample;
    }





}