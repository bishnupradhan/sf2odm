<?php
namespace B2\MainBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/** @MongoDB\Document */
abstract class Question {

    /**
     * @MongoDB\Id
     */
    protected  $id;

    /**
     * @MongoDB\ObjectId
     * @Assert\NotBlank()
     */
    protected $userTestDocumentId;

    /**
     * @MongoDB\Int
     * @Assert\NotBlank()
     */
    protected $numQuestions;


    abstract public function render();


    public function getId(){
    return $this->id;
    }

    public function setUserTestDocumentId($userTestDocumentId) {
        $this->userTestDocumentId = $userTestDocumentId;
    }

    public function getUserTestDocumentId()
    {
        return $this->userTestDocumentId;
    }

    public function setNumberQuestions($numQuestions){
        $this->numQuestions = $numQuestions;

    }

    public function getNumberQuestions(){
        return $this->numQuestions;
    }




    protected function getRandomRange($min, $max) {
        return rand($min, $max);
    }

    protected function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    /*
     * Finding cartesian product with associative arrays
     */
    protected function cartesianProduct($input) {
        $result = array();

        while (list($key, $values) = each($input)) {
            // If a sub-array is empty, it doesn't affect the cartesian product
            if (empty($values)) {
                continue;
            }

            // Seeding the product array with the values from the first sub-array
            if (empty($result)) {
                foreach($values as $value) {
                    $result[] = array($key => $value);
                }
            }
            else {
                // Second and subsequent input sub-arrays work like this:
                //   1. In each existing array inside $product, add an item with
                //      key == $key and value == first item in input sub-array
                //   2. Then, for each remaining item in current input sub-array,
                //      add a copy of each existing array inside $product with
                //      key == $key and value == first item of input sub-array

                // Store all items to be added to $product here; adding them
                // inside the foreach will result in an infinite loop
                $append = array();

                foreach($result as &$product) {
                    // Do step 1 above. array_shift is not the most efficient, but
                    // it allows us to iterate over the rest of the items with a
                    // simple foreach, making the code short and easy to read.
                    $product[$key] = array_shift($values);

                    // $product is by reference (that's why the key we added above
                    // will appear in the end result), so make a copy of it here
                    $copy = $product;

                    // Do step 2 above.
                    foreach($values as $item) {
                        $copy[$key] = $item;
                        $append[] = $copy;
                    }

                    // Undo the side effecst of array_shift
                    array_unshift($values, $product[$key]);
                }

                // Out of the foreach, we can add to $results now
                $result = array_merge($result, $append);
            }
        }

        return $result;
    }

    /*
     * Get the result of an equation
     */
    public function calc($equation)
    {
        // Remove whitespaces
        $equation = preg_replace('/\s+/', '', $equation);
        //echo "$equation\n";

        $number = '(?:-?\d+(?:[,.]\d+)?|pi|π)'; // What is a number
        $functions = '(?:sinh?|cosh?|tanh?|abs|acosh?|asinh?|atanh?|exp|log10|deg2rad|rad2deg|sqrt|ceil|floor|round)'; // Allowed PHP functions
        $operators = '[+\/*\^%-]'; // Allowed math operators
        $regexp = '/^(('.$number.'|'.$functions.'\s*\((?1)+\)|\((?1)+\))(?:'.$operators.'(?1))?)+$/'; // Final regexp, heavily using recursive patterns

        if (preg_match($regexp, $equation))
        {
            $equation = preg_replace('!pi|π!', 'pi()', $equation); // Replace pi with pi function
            //echo "$equation\n";
            eval('$result = '.$equation.';');
        }
        else
        {
            $result = false;
        }
        return $result;
    }

}