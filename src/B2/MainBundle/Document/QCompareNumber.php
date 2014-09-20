<?php
namespace B2\MainBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use B2\MainBundle\Document\Question;

/** @ODM\Document(collection="qcomparenumber") */
class QCompareNumber extends Question
{


    /** @ODM\Id */
    protected $id;

    /** @ODM\Int */
    protected $numberMin;

    /** @ODM\Int */
    protected $numberMax;

    /*** @ODM\String */
    protected $qStatus;


    protected $finalRenderedHTML;

    protected $answerObjectInsertID;


    public function __construct($id= null)
    {
        $this->id = $id;
    }

    public function getFinalRenderedHTML(){
        return $this->finalRenderedHTML;
    }

    public function setFinalRenderedHTML($finalRenderedHTML){
        $this->finalRenderedHTML = $finalRenderedHTML;
    }

    public function getNumberMin(){
        return $this->numberMin;
    }

    public function setNumberMin($numberMin) {
        $this->numberMin = $numberMin;
    }

    public function getNumberMax() {
        return $this->numberMax;
    }

    public function setNumberMax($numberMax) {
        $this->numberMax = $numberMax;
    }

    public function getId(){
        return $this->id;
    }

    public function setQStatus($qStatus)
    {
        $this->qStatus = $qStatus;
    }

    public function getQStatus()
    {
        return $this->qStatus;
    }

    public function create_questions($dm) {
        /*echo "create question";
        //var_dump($this);
        exit;*/
        $answerObject = new ACompareNumber($this->id);

        $firstNumberArray = parent::UniqueRandomNumbersWithinRange($this->numberMin, $this->numberMax, $this->numQuestions);
        $secondNumberArray = parent::UniqueRandomNumbersWithinRange($this->numberMin, $this->numberMax, $this->numQuestions);

        for($i=0; $i< $this->numQuestions; $i++){

            if(!empty($firstNumberArray)){
                $firstNumber = array_shift($firstNumberArray);
            }
            else {
                $firstNumber = parent::getRandomRange($this->numberMin, $this->numberMax);
            }

            if(!empty($secondNumberArray)) {
                $secondNumber = array_shift($secondNumberArray);
            }
            else {
                $secondNumber = parent::getRandomRange($this->numberMin, $this->numberMax);
            }

        //var_dump($firstNumber);
        //var_dump($secondNumber);

        if($firstNumber > $secondNumber){
            $compareValue = "&#62;"; //is Greater than  " >	&gt;	&#62;	&#x3E; "
            $compareText = "is greater than";
        }
        elseif($firstNumber === $secondNumber){
            $compareValue = "&#61;"; //is equal " = "
            $compareText = "is equal to";
        }
        else {
            $compareValue = "&#60;"; //is Less Than " <	&lt;	&#60;	&#x3C; "
            $compareText = "is less than";
        }

        if($i==0){
            $arr[] = array('firstNumber'=>$firstNumber, 'secondNumber'=>$secondNumber,
                'compareValue'=>$compareValue, 'compareText'=> $compareText, 'preFill'=>true);
        }
        else {
            $arr[] = array('firstNumber'=>$firstNumber, 'secondNumber'=>$secondNumber,
                'compareValue'=>$compareValue, 'compareText'=> $compareText, 'preFill'=>false);
            }
        //$html =  "<div><span>" . $firstNumber ."</span><span>" . $compareValue . "</span><span>" . $secondNumber ."</span>";
        //echo $html;

        }
        $answerObject->setAnswers($arr);

        $dm->persist($answerObject);
        $dm->flush();
        $this->answerObjectInsertID = $answerObject->getID();


    /*print "<pre>";
    print_r($arr);
    print "</pre>";//exit;*/
    $this->renderDisplay($arr);
    }

    public function render()
    {

        $hiddenAnswerObjectID = "<input type='hidden' readonly='readonly' name='answerObjID' value='". $this->answerObjectInsertID . "'>";
        $hiddenQuestionObjectID = "<input type='hidden' readonly='readonly' name='questionObjID' value='". $this->id . "'>";
        $hiddenQuestionClassName = "<input type='hidden' readonly='readonly' name='questionClassName' value='". get_class($this) . "'>";
        $addHtml = "<div class='cl'></div>";
        return $this->finalRenderedHTML . $hiddenAnswerObjectID . $hiddenQuestionObjectID . $hiddenQuestionClassName .$addHtml;

    }

    protected  function renderDisplay($array) {

        foreach($array as $k=>$v){
            $html = '';
            if($v['preFill']){
                $html .=  "<div class='worksheetStyle'><div class='form-panel'><span>" . $v['firstNumber'] ."</span><span><input type='text' class='blue-input' name='cmpInput[".$k."]' value='" . $v['compareValue'] . "' readonly='true'></span><span>" . $v['secondNumber'] ."</span></div>";

            }
            else {
                $html .=  "<div class='worksheetStyle'><div class='form-panel'><span>" . $v['firstNumber'] ."</span><span><input type='text' class='gray-input' name='cmpInput[".$k."]' value=''></span><span>" . $v['secondNumber'] ."</span></div>";
            }
            $html .= "</div>";
            $this->finalRenderedHTML .= $html;
        }
    }


}