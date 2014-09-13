<?php

namespace B2\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/*use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;*/

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use B2\MainBundle\Document;
use B2\MainBundle\AnswerSheet;

class TestController extends Controller
{

    /**
     * This is for setting the question model type. which leads to corresponding question model view.
     * @param $cat      // category
     * @param $type     // subcat or question type
     * @return Response
     */

    public function setTestingAction($cat,$type){

        $qDoc = "Q".$this->getProperFormat($type);

        $repository = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('B2MainBundle:Category');

        $Qtype = '\B2\MainBundle\Document\\'.$qDoc;
        $modelName = strtolower($this->getProperFormat($type));
        $user = 'Bishnu';   // todo: user name to be fetch from session

        $questionType = new $Qtype();
        /*print "<pre>"; print_r($questionType); print "</pre>";exit;*/
        return $this->render('B2MainBundle:Test:setTesting.html.twig',
            array(
                'questionType' => $questionType,
                'modelName'=>$modelName,
                'category'=>$cat,
                'subcategory'=>$type,
                'user'=>$user
            ));


    }

    /**
     * This set the UserTest and Corresponding question type model (q type).
     * And leads to 'start the practice' view
     * @return Response
     */
    public function setQuestionAction(){

        /*print "<pre>".date("Y-m-d H:m:s");
        print_r($_REQUEST);
        print "</pre>";exit;*/


        $dm = $this->get('doctrine_mongodb')->getManager();

        $userTest = new \B2\MainBundle\Document\UserTest();
        $userTest->setUser($_REQUEST['QuestionSet']['user']);
        $userTest->setCategory($_REQUEST['QuestionSet']['category']);
        $userTest->setSubcategory($_REQUEST['QuestionSet']['subcategory']);
        $userTest->setDateTime(date("Y-m-d H:m:s"));
        $userTest->setIp($this->container->get('request')->getClientIp());
        $userTest->setIsTestComplete("0");

        $dm->persist($userTest);
        $dm->flush();

        $userTestId = $userTest->getId();

        if(!empty($userTestId)){
            // go for indivisual test setting
            $modelName = trim($_REQUEST['modelName']);

            //echo $this->getProperFormat($_REQUEST['QuestionSet']['subcategory']);exit;
            $qDoc = '\B2\MainBundle\Document\\'."Q".$this->getProperFormat($_REQUEST['QuestionSet']['subcategory']);

            $questionType = new $qDoc();

            $questionType->setUserTestDocumentId($userTestId);
            $questionType->setNumberQuestions($_REQUEST['QuestionSet']['numQuestion']);
            $questionType->setNumberMin($_REQUEST[$modelName]['numberMin']);
            $questionType->setNumberMax($_REQUEST[$modelName]['numberMax']);

            $dm->persist($questionType);
            $dm->flush();
            $questionTypeId = $questionType->getId();

            if(!empty($questionTypeId)){
                return $this->render('B2MainBundle:Test:startTest.html.twig',
                    array(
                        'modelName'=>$modelName,
                        'category'=>$_REQUEST['QuestionSet']['category'],
                        'subcategory'=>$_REQUEST['QuestionSet']['subcategory'],
                        'user'=>$_REQUEST['QuestionSet']['user'],
                        'questionDocumentTypeID'=>$questionTypeId
                    ));
            }else{
                echo "not insert to questionType db";exit;
            }
        }else{
            echo "not insert to userTest db";exit;
        }
    }


    /**
     * After confirmation from user to start the test.
     * - prepare the question and set into system answer into Corresponding question type model (a type).
     * - leads to corresponding question model view with generated questions
     * @return mixed
     */
    public function testAction(){
        //print "<pre>";print_r($_REQUEST);print "</pre>";exit;

        //$modelName = "q".$_REQUEST['modelName'];
        $questionDocumentTypeID = $_REQUEST['questionDocumentTypeID'];


        $dm = $this->get('doctrine_mongodb')->getManager();


        $qClassType = $this->getProperFormat(trim($_REQUEST['subcategory']));
        $qDoc = '\B2\MainBundle\Document\\'."Q".$qClassType;
        $bundle = 'B2MainBundle:'."Q".$qClassType;

        $qb = $dm->createQueryBuilder($bundle)
            ->hydrate(false)
            ->field('id')->equals($questionDocumentTypeID);
        $query = $qb->getQuery();
        $questionStructure = $query->getSingleResult();

        /*print "<pre>";var_dump($questionStructure);print "</pre>";exit;*/

        /////////////////////////////////////////////////////////

        $questionObject = new  $qDoc($questionStructure['_id']);

        //return $this->processByQuestionClassType($questionObject, $questionStructure, $qClassType);
        $classObjDisplay = $this->processByQuestionClassType($questionObject, $questionStructure, $qClassType);

        return $this->render('B2MainBundle:Test:_display.html.twig',
            array(
                'category'=>$_REQUEST['category'],
                'subcategory'=>$_REQUEST['subcategory'],
                'user'=>$_REQUEST['user'],
                'classObjDisplay'=> $classObjDisplay
            ));

    }

    protected function processByQuestionClassType($classObject, $mongoObject, $classType) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $funcName = "processQ".$classType;
        return $this->$funcName($classObject, $mongoObject,$dm);
    }

    // making proper format
    protected function getProperFormat($arg){
        $qDoc = explode("-",$arg);
        $qType = '';
        foreach($qDoc as $v){
            $qType .= ucfirst($v);
        }
        return trim($qType);
    }


    //************************** Create Question for indivisual question type Strats*******************************//
    public function processQCompareNumber($classObject, $mongoObject,$dm){
        $classObject->setUserTestDocumentId($mongoObject['userTestDocumentId']);
        $classObject->setNumberQuestions($mongoObject['numQuestions']);
        $classObject->setNumberMin($mongoObject['numberMin']);
        $classObject->setNumberMax($mongoObject['numberMax']);
        $classObject->create_questions($dm);

        /*return $this->render('B2MainBundle:Test:_display.html.twig',
            array('classObjDisplay'=> $classObject->render())
        );*/
        return $classObject->render();
    }




    /// ***** End of Create Question part ****///


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * The user's given answers are going to storeed in coresponding question model (a type)
     * - leads to result page
     * - the result page consits for score after evaluation and answer sheet
     * @return Response
     */
    public function submitAction(){
        //print "<pre>";print_r($_REQUEST);print "</pre>";exit;
        $clsType = $_REQUEST['questionClassName'];

        $explodedClass = explode('\\', $clsType);
        $answerClassType = $explodedClass[3];

        $questionClass = substr($answerClassType,1);

        $funcName = "processA".$questionClass;

        $scoreWithAnsSheet = $this->$funcName();    // answer submission and calculate the score with answersheet

        return $this->render('B2MainBundle:Test:_result.html.twig',
            array('result'=> $scoreWithAnsSheet,
                'questionClassType'=>$questionClass,
                'answerObjID'=>$_REQUEST['answerObjID'],
                'category'=>$_REQUEST['category'],
                'subcategory'=>$_REQUEST['subcategory'],
                'user'=>$_REQUEST['user'],
            )
        );
    }


    //************************** User Answer storing part  for indivisual question type Strats*******************************//
    protected function processACompareNumber(){
        //var_dump($_REQUEST);
        $dm = $this->get('doctrine_mongodb')->getManager();
        $studentAnswerObject = new \B2\MainBundle\Document\ACompareNumber($_REQUEST['questionObjID']);
        $studentAnswerObject->setAnswerObjectID($_REQUEST['answerObjID']);
        //todo: change this to be dynamic depending upon the student giving the test
        $studentAnswerObject->setUser('TestUser');
        foreach($_REQUEST['cmpInput'] as $answerKey=>$answerValue){
            switch($answerValue){
                case '<': $compareValue = '&#60;';
                    break;
                case '=': $compareValue = '&#61;';
                    break;
                case '>': $compareValue = '&#62;';
                    break;
                default: $compareValue = $answerValue;
                break;
            }
            $arr[] = array('compareValue'=>$compareValue);
        }
        $studentAnswerObject->setAnswers($arr);
        //var_dump($arr);
        $dm->persist($studentAnswerObject);
        $dm->flush();
        //echo $studentAnswerObject->getID();
        //echo "<hr/>";//exit;
        $function = "Q".ltrim (__FUNCTION__,'processA');
        $res = $this->actionEvaluate($studentAnswerObject->getID(), $function); // to be return
        //echo $res."<hr/>";//exit;
        ///////////////////////////// go for answer sheet  //////////////////////////////////

        $studentMongoArray = array('classType'=>'CompareNumber',
            'studentAnswerMongoID'=>$studentAnswerObject->getID(),
            'answerObjectID'=>$studentAnswerObject->getAnswerObjectID());
        $html = $this->getAnswerHtmlDumpForEach($studentMongoArray);

        $result = array('status'=>$res,'answerSheet'=>$html);
        return $result;


    }

    /// ***** End of User Answer storing part ****///
    //////////////////////////////////////// Evaluation ////////////////////////////////////////////////////////////////////////////////////
    /**
     * Evauation process for corespongind answer
     * @param string $studentAnswerObjectID
     * @param string $questionClassType
     * @return string
     */
    public function actionEvaluate($studentAnswerObjectID='',$questionClassType='') {
        if((isset($_REQUEST['stuAnswerObjectID']) && $_REQUEST['questionClassType']) || (!empty($studentAnswerObjectID) && !empty($questionClassType))){
            $studentAnswerObjectID = isset($_REQUEST['stuAnswerObjectID']) ? $_REQUEST['stuAnswerObjectID'] : $studentAnswerObjectID;
            $questionClassType = isset($_REQUEST['questionClassType']) ? $_REQUEST['questionClassType'] : $questionClassType;
            $classType = ltrim ($questionClassType,'Q');
            $answerDocumentClass = 'A'.$classType;
            $bundle = 'B2MainBundle:';

            $dm = $this->get('doctrine_mongodb')->getManager();
            $document =  $bundle.$answerDocumentClass;

            /////////////////////  Get the Student Answer //////////////////////////////////
            $qb = $dm->createQueryBuilder($document)
                ->hydrate(false)
                ->field('id')->equals($studentAnswerObjectID);
            $query = $qb->getQuery();
            $studentAnswerArray = $query->getSingleResult();
            //print "<pre>";var_dump($studentAnswerArray);print "</pre>";


            ////////////////////  Get the Corresponding System Answer /////////////////////
            $systemAnswerObjectId = $studentAnswerArray['answerObjectId'];
            $qBuilder = $dm->createQueryBuilder($document )
                ->hydrate(false)
                ->field('id')->equals($systemAnswerObjectId)
                ->field('user')->equals('system');
            $mongoQuery = $qBuilder->getQuery();
            $systemAnswerArray = $mongoQuery->getSingleResult();
            //print "<pre>";var_dump($systemAnswerArray);print "</pre>";//exit;

            /// call evaluation method
            $classTypeName = '\B2\MainBundle\Document\\'.$answerDocumentClass;
            $evalObj = new $classTypeName();
            if($answerDocumentClass == 'AIncremental') {
                $evalScore = $evalObj->evaluation($systemAnswerArray['answers'], $studentAnswerArray['answers'], $systemAnswerArray['preFilledIndexes']);
            }
            elseif($answerDocumentClass== 'AFractionEquivalent'){
                $evalScore = $evalObj->evaluation($systemAnswerArray['answers'], $studentAnswerArray['answers'], $systemAnswerArray['maxEquivalents']);

            }
            else {
                $evalScore = $evalObj->evaluation($systemAnswerArray['answers'], $studentAnswerArray['answers']);
            }
            if($evalScore >= 75){
                $msg = "Pass with ".$evalScore."%";
            }
            else {
                $msg = "Fail with ".$evalScore."%";
            }

            return $msg;

        }else{
            // to be redirect
            echo "No answer id selected";exit;
        }
    }

    /**
     * Answer sheet
     * @param $studentMongoArray
     * @return mixed
     */
    protected function getAnswerHtmlDumpForEach($studentMongoArray){
        $dm = $this->get('doctrine_mongodb')->getManager();
        $class = "\B2\MainBundle\AnswerSheet\\".$studentMongoArray['classType'];
        $obj = new $class();
        $obj->setArray($studentMongoArray);
        $obj->processMongoResult($dm);
        return ($obj->getHtmlDump());
    }


}
