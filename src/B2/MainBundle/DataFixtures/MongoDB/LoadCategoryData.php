<?php

namespace B2\MainBundle\DataFixtures\MongoDB;


use B2\MainBundle\Document\Category;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;



class LoadCategoryData implements FixtureInterface{

    public function load(ObjectManager $manager)
    {
        /* Data Handling */
        $cat1 = new Category();
        $cat1->setCategoryName("Data Handling");
        $cat1->setCategory("data-handling");
        $subC1 = array(array('subcategoryName'=>'Count', 'subcategory'=>'count'));
        $cat1->setSub($subC1);
        $manager->persist($cat1);

        /* Factors & Multiples */
        $cat2 = new Category();
        $cat2->setCategoryName("Factors & Multiples");
        $cat2->setCategory("factors-Multiples");
        $subC2 = array(array('subcategoryName'=>'Factors', 'subcategory'=>'factors'));
        $cat2->setSub($subC2);
        $manager->persist($cat2);

        $cat3 = new Category();
        $cat3->setCategoryName("Fractions");
        $cat3->setCategory("fractions");
        $subC3 = array(
            array('subcategoryName'=>'Fraction Compare', 'subcategory'=>'fraction-compare'),
            array('subcategoryName'=>'Fraction Equivalent', 'subcategory'=>'fraction-equivalent'),
            array('subcategoryName'=>'Fraction Improper To Mixed', 'subcategory'=>'fraction-improper-to-mixed'),
            array('subcategoryName'=>'Fraction Operation', 'subcategory'=>'fraction-operation'),
            array('subcategoryName'=>'Proper Fraction', 'subcategory'=>'proper-fraction')
        );
        $cat3->setSub($subC3);
        $manager->persist($cat3);

        $cat4 = new Category();
        $cat4->setCategoryName("Measurement");
        $cat4->setCategory("measurement");
        $subC4 = array(
            array('subcategoryName'=>'Length', 'subcategory'=>'length'),
            array('subcategoryName'=>'Length Conversion', 'subcategory'=>'length-conversion'),
            array('subcategoryName'=>'Weight', 'subcategory'=>'weight'),
            array('subcategoryName'=>'Weight Conversion', 'subcategory'=>'weight-conversion'),
            array('subcategoryName'=>'Volume', 'subcategory'=>'volume'),
            array('subcategoryName'=>'Volume Conversion', 'subcategory'=>'volume-conversion')
        );
        $cat4->setSub($subC4);
        $manager->persist($cat4);

        $cat5 = new Category();
        $cat5->setCategoryName("Number System");
        $cat5->setCategory("number-system");
        $subC5 = array(
            array('subcategoryName'=>'Compare Number', 'subcategory'=>'compare-number'),
            array('subcategoryName'=>'Count', 'subcategory'=>'count'),
            array('subcategoryName'=>'Decimal', 'subcategory'=>'decimal'),
            array('subcategoryName'=>'Decimal Operation', 'subcategory'=>'decimal-operation'),
            array('subcategoryName'=>'Division', 'subcategory'=>'division'),
            array('subcategoryName'=>'Expanded Notation', 'subcategory'=>'expanded-notation'),
            array('subcategoryName'=>'Incremental', 'subcategory'=>'incremental'),
            array('subcategoryName'=>'Operation', 'subcategory'=>'operation'),
            array('subcategoryName'=>'Operation Lower Class', 'subcategory'=>'operation-lower-class'),
            array('subcategoryName'=>'Operation With Zero', 'subcategory'=>'operation-with-zero'),
            array('subcategoryName'=>'Ordinal', 'subcategory'=>'ordinal'),
            array('subcategoryName'=>'Place Value', 'subcategory'=>'place-value'),
            array('subcategoryName'=>'Word Problem', 'subcategory'=>'wordproblem')
        );
        $cat5->setSub($subC5);
        $manager->persist($cat5);

        $cat6 = new Category();
        $cat6->setCategoryName("Pattern");
        $cat6->setCategory("pattern");
        $subC6 = array(
            array('subcategoryName'=>'Pattern Multi Variables', 'subcategory'=>'pattern-multi-variables'),
            array('subcategoryName'=>'Pattern Numerical', 'subcategory'=>'pattern-numerical'),
            array('subcategoryName'=>'Pattern Set', 'subcategory'=>'pattern-set'),
            array('subcategoryName'=>'Pattern Two Variables', 'subcategory'=>'pattern-two-variables'),
            array('subcategoryName'=>'Symmetrical Patterns', 'subcategory'=>'symmetrical-patterns')
        );
        $cat6->setSub($subC6);
        $manager->persist($cat6);

        $cat7 = new Category();
        $cat7->setCategoryName("Time");
        $cat7->setCategory("time");
        $subC7 = array(
            array('subcategoryName'=>'Time', 'subcategory'=>'time'),
            array('subcategoryName'=>'Time Conversion', 'subcategory'=>'time-conversion'),
            array('subcategoryName'=>'Time Conversion AMPM', 'subcategory'=>'time-conversionAMPM'),
            array('subcategoryName'=>'TimeOperation', 'subcategory'=>'time-operation')
        );
        $cat7->setSub($subC7);
        $manager->persist($cat7);

        $cat8 = new Category();
        $cat8->setCategoryName("Chart");
        $cat8->setCategory("chart");
        $subC8 = array(
            array('subcategoryName'=>'Bar Graph', 'subcategory'=>'bar-graph'),
            array('subcategoryName'=>'Pie Graph', 'subcategory'=>'pie-graph')
        );
        $cat8->setSub($subC8);
        $manager->persist($cat8);




        $manager->flush();

    }

} 