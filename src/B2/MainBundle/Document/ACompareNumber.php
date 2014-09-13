<?php
namespace B2\MainBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="acomparenumber") */
class ACompareNumber  {

    /** @ODM\Id */
    protected $id;

    /** @ODM\ObjectId */
    protected $questionDocumentId; //Mongo Object ID of Different Type of Question

    /** @ODM\String */
    protected $user;

    /** @ODM\Collection */
    protected $answers = array();

    /** @ODM\ObjectId */
    protected $answerObjectId;


    public function __construct($questionDocumentId=null, $user='system'){
        $this->questionDocumentId = $questionDocumentId;
        $this->user = $user;
    }


    public function getID(){
        return $this->id;
    }

    public function getQuestionDocumentId(){
        return $this->questionDocumentId;
    }

    public function setQuestionDocumentId($questionDocumentId){
        $this->questionDocumentId = $questionDocumentId;
    }

    public function getUser(){
        return $this->user;
    }

    public function setUser($user){
        $this->user = $user;
        return $this;
    }

    public function getAnswerObjectID(){
        return $this->answerObjectId;
    }

    public function setAnswerObjectID($answerObjectID){
        $this->answerObjectId = $answerObjectID;
        return $this;
    }

    public function getAnswers(){
        return $this->answers;
    }

    public function setAnswers($answer) {
        $this->answers[] = $answer;
        return $this;
    }

    public function evaluation($systemAnswers, $studentAnswers){

         //var_dump($systemAnswers);
         //var_dump($studentAnswers);
        $actualAnswers = sizeof($systemAnswers[0]);
        $correctAnswer = 0;
        foreach($systemAnswers as $sysAnswerK=>$sysAnswerV){

            foreach($sysAnswerV as $k=>$v){
                if($v['preFill'])
                {
                    $actualAnswers = $actualAnswers - 1;
                }
                else {
                    if($v['compareValue'] === $studentAnswers[$sysAnswerK][$k]['compareValue']){
                        $correctAnswer++;
                    }
                    /* echo $v['compareValue'] , 'H';
                     echo $studentAnswers[$sysAnswerK][$k]['compareValue'] . "  ==  ";*/
                }
            }
            //var_dump($actualAnswers);
            //var_dump($correctAnswer);
            $scoredPercentage = (($correctAnswer/$actualAnswers) * 100);
            return $scoredPercentage;
        }


    }

}