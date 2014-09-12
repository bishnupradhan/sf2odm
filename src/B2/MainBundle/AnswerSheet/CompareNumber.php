<?php
namespace B2\MainBundle\AnswerSheet;

class CompareNumber {
    private $studentAnswer = array();
    private $processArray = array();
    private $generatedQArr = array();


    public function setArray($arr){
        $this->studentAnswer = $arr;
    }

    public function getArray(){
        return $this->studentAnswer;
    }

    public function processMongoResult($docMgr){
        /*print "<pre>";
        print_r($this->studentAnswer);
        print "<pre>";exit;*/
        $questionText = '';


        $this->studentAnswer['question'] = 'Solve this';
        $aClass = $this->studentAnswer['classType'];
        $aClass = '\B2\MainBundle\Document\\'.'A'.$aClass;

        //$aClass = substr($this->studentAnswer['questionClassType'], 1);

        // get the student answer
        $qBuilder =  $docMgr->createQueryBuilder($aClass )
            ->hydrate(false)
            ->field('_id')->equals($this->studentAnswer['studentAnswerMongoID']);
        $query = $qBuilder->getQuery();
        $studentMongoAnswer = $query->getSingleResult();

        // get the system answer
        $qbGenerated = $docMgr->createQueryBuilder($aClass )
            ->hydrate(false)
            ->field('_id')->equals($studentMongoAnswer['answerObjectId']);
        $queryGenerated = $qbGenerated->getQuery();
        $generatedQuestion = $queryGenerated->getSingleResult();

        $this->generatedQArr = $generatedQuestion['answers'][0];

        //print "<pre>";
        /*print_r($questionStructure);
        print "<hr/>System Answer :";
        print_r($this->generatedQArr);
        print "<hr/>Student Answer :";
        print_r($studentMongoAnswer['answers'][0]);
        print "</pre>";exit;*/

        foreach($this->generatedQArr as $k=>$v){
            $generatedQuestion['correctAnswer'][] = $v['compareValue'];
        }

        // result array
        //$this->processArray['Question'] = $questionText;
        $this->processArray['CorrectAnswer'] = $generatedQuestion['correctAnswer'];
        $this->processArray['StudentAnswer']= $studentMongoAnswer['answers'][0];
        $this->processArray['QuestionText']= $this->studentAnswer['question'];
        //print_r($this->processArray);exit;

        // html output
    }

    public function getHtmlDump(){
        $html = '';
        $html .= "<div class='answerSet'><div class='questionTxt'>".$this->studentAnswer['question']."</div>";

        foreach($this->generatedQArr as $k=>$v){

            $htmlStr = '';
            $htmlStr .= "<div class='sheet-form-panel'>";

            $symbol = ($this->processArray['CorrectAnswer'][$k] === $this->processArray['StudentAnswer'][$k]['compareValue']) ? "icon-ok" : "icon-remove";
            $correctAnswer = ($this->processArray['CorrectAnswer'][$k] === $this->processArray['StudentAnswer'][$k]['compareValue']) ? "" : "<div class='correctAns'> Correct Answer - ".$this->processArray['CorrectAnswer'][$k]."</div>";

            $htmlStr .= "<div class='questionOne'>"
                ."<span> " . $v['firstNumber'] . "</span>"
                ."</div>"
                ."<div class='AnswerOne'>"
                ."<span class='answerFld'>".$this->processArray['StudentAnswer'][$k]['compareValue']."</span>"
                ."<span> " . $v['secondNumber'] . " </span>"
                ."</div>"
                ."</div>"
                ."<div class='symbol'><i class=".$symbol."></i></div>".$correctAnswer."<div class='cl'></div>"."<div class='cl'></div>";
            $html .= $htmlStr;
        }


        $html .= "</div>";
        return $html;
        //echo $html;exit;
    }

}