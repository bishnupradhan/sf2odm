<?php

namespace B2\MainBundle\DataFixtures\MongoDB;


use B2\MainBundle\Document\Address;
use B2\MainBundle\Document\Category;

use B2\MainBundle\Document\Person;
use B2\MainBundle\Document\Subcategory;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;



class LoadCategoryData implements FixtureInterface{

    public function load(ObjectManager $manager)
    {


        $cat1 = new Category();
        $cat1->setCategoryName("Data Handling");
        $cat1->setCategory("data-handling");

        $subC1 = new Subcategory();
        $subC1->setSubcategoryName('Count');
        $subC1->setSubcategory('count');
        $subC1->setIsSample(false);
        $cat1->setSub($subC1);
        $manager->persist($cat1);

        $cat2 = new Category();
        $cat2->setCategoryName("Factors & Multiples");
        $cat2->setCategory("factors-Multiples");

        $subC2 = new Subcategory();
        $subC2->setSubcategoryName('Factors');
        $subC2->setSubcategory('factors');
        $subC2->setIsSample(false);
        $cat2->setSub($subC2);
        $manager->persist($cat2);

        $cat3 = new Category();
        $cat3->setCategoryName("Fractions");
        $cat3->setCategory("fractions");

        $subC3 = new Subcategory();
        $subC3->setSubcategoryName('Fraction Compare');
        $subC3->setSubcategory('fraction-compare');
        $subC3->setIsSample(false);

        $subC3_a = new Subcategory();
        $subC3_a->setSubcategoryName('Fraction Equivalent');
        $subC3_a->setSubcategory('fraction-equivalent');
        $subC3_a->setIsSample(false);

        $subC3_b = new Subcategory();
        $subC3_b->setSubcategoryName('Fraction Improper To Mixed');
        $subC3_b->setSubcategory('fraction-improper-to-mixed');
        $subC3_b->setIsSample(false);

        $subC3_c = new Subcategory();
        $subC3_c->setSubcategoryName('Fraction Operation');
        $subC3_c->setSubcategory('fraction-operation');
        $subC3_c->setIsSample(false);

        $subC3_d = new Subcategory();
        $subC3_d->setSubcategoryName('Proper Fraction');
        $subC3_d->setSubcategory('proper-fraction');
        $subC3_d->setIsSample(false);

        $cat3->setSub($subC3);
        $cat3->setSub($subC3_a);
        $cat3->setSub($subC3_b);
        $cat3->setSub($subC3_c);
        $cat3->setSub($subC3_d);
        $manager->persist($cat3);

        $cat4 = new Category();
        $cat4->setCategoryName("Measurement");
        $cat4->setCategory("measurement");

        $subC4_a = new Subcategory();
        $subC4_a->setSubcategoryName('Length');
        $subC4_a->setSubcategory('length');
        $subC4_a->setIsSample(false);

        $subC4_b = new Subcategory();
        $subC4_b->setSubcategoryName('Length Conversion');
        $subC4_b->setSubcategory('length-conversion');
        $subC4_b->setIsSample(false);

        $subC4_c = new Subcategory();
        $subC4_c->setSubcategoryName('Weight');
        $subC4_c->setSubcategory('weight');
        $subC4_c->setIsSample(false);

        $subC4_d = new Subcategory();
        $subC4_d->setSubcategoryName('Weight Conversion');
        $subC4_d->setSubcategory('weight-conversion');
        $subC4_d->setIsSample(false);

        $subC4_e = new Subcategory();
        $subC4_e->setSubcategoryName('Volume');
        $subC4_e->setSubcategory('volume');
        $subC4_e->setIsSample(false);

        $subC4_f = new Subcategory();
        $subC4_f->setSubcategoryName('Volume Conversion');
        $subC4_f->setSubcategory('volume-conversion');
        $subC4_f->setIsSample(false);

        $cat4->setSub($subC4_a);
        $cat4->setSub($subC4_b);
        $cat4->setSub($subC4_c);
        $cat4->setSub($subC4_d);
        $cat4->setSub($subC4_e);
        $cat4->setSub($subC4_f);

        $manager->persist($cat4);

        $cat5 = new Category();
        $cat5->setCategoryName("Number System");
        $cat5->setCategory("number-system");

        $subC5_a = new Subcategory();
        $subC5_a->setSubcategoryName('Compare Number');
        $subC5_a->setSubcategory('compare-number');
        $subC5_a->setIsSample(false);

        $subC5_b = new Subcategory();
        $subC5_b->setSubcategoryName('Count');
        $subC5_b->setSubcategory('count');
        $subC5_b->setIsSample(false);

        $subC5_c = new Subcategory();
        $subC5_c->setSubcategoryName('Decimal');
        $subC5_c->setSubcategory('decimal');
        $subC5_c->setIsSample(false);

        $subC5_d = new Subcategory();
        $subC5_d->setSubcategoryName('Decimal Operation');
        $subC5_d->setSubcategory('decimal-operation');
        $subC5_d->setIsSample(false);

        $subC5_e = new Subcategory();
        $subC5_e->setSubcategoryName('Division');
        $subC5_e->setSubcategory('division');
        $subC5_e->setIsSample(false);

        $subC5_f = new Subcategory();
        $subC5_f->setSubcategoryName('Expanded Notation');
        $subC5_f->setSubcategory('expanded-notation');
        $subC5_f->setIsSample(false);

        $subC5_g = new Subcategory();
        $subC5_g->setSubcategoryName('Incremental');
        $subC5_g->setSubcategory('incremental');
        $subC5_g->setIsSample(false);

        $subC5_h = new Subcategory();
        $subC5_h->setSubcategoryName('Operation');
        $subC5_h->setSubcategory('operation');
        $subC5_h->setIsSample(false);

        $subC5_i = new Subcategory();
        $subC5_i->setSubcategoryName('Operation Lower Class');
        $subC5_i->setSubcategory('operation-lower-class');
        $subC5_i->setIsSample(false);

        $subC5_j = new Subcategory();
        $subC5_j->setSubcategoryName('Operation With Zero');
        $subC5_j->setSubcategory('operation-with-zero');
        $subC5_j->setIsSample(false);

        $subC5_k = new Subcategory();
        $subC5_k->setSubcategoryName('Ordinal');
        $subC5_k->setSubcategory('ordinal');
        $subC5_k->setIsSample(false);

        $subC5_l = new Subcategory();
        $subC5_l->setSubcategoryName('Place Value');
        $subC5_l->setSubcategory('place-value');
        $subC5_l->setIsSample(false);

        $subC5_m = new Subcategory();
        $subC5_m->setSubcategoryName('Word Problem');
        $subC5_m->setSubcategory('wordproblem');
        $subC5_m->setIsSample(false);


        $cat5->setSub($subC5_a);
        $cat5->setSub($subC5_b);
        $cat5->setSub($subC5_c);
        $cat5->setSub($subC5_d);
        $cat5->setSub($subC5_e);
        $cat5->setSub($subC5_f);
        $cat5->setSub($subC5_g);
        $cat5->setSub($subC5_h);
        $cat5->setSub($subC5_i);
        $cat5->setSub($subC5_j);
        $cat5->setSub($subC5_k);
        $cat5->setSub($subC5_l);
        $cat5->setSub($subC5_m);
        $manager->persist($cat5);

        $cat6 = new Category();
        $cat6->setCategoryName("Pattern");
        $cat6->setCategory("pattern");

        $subC6_a = new Subcategory();
        $subC6_a->setSubcategoryName('Pattern Multi Variables');
        $subC6_a->setSubcategory('pattern-multi-variables');
        $subC6_a->setIsSample(false);

        $subC6_b = new Subcategory();
        $subC6_b->setSubcategoryName('Pattern Numerical');
        $subC6_b->setSubcategory('pattern-numerical');
        $subC6_b->setIsSample(false);

        $subC6_c = new Subcategory();
        $subC6_c->setSubcategoryName('Pattern Set');
        $subC6_c->setSubcategory('pattern-set');
        $subC6_c->setIsSample(false);

        $subC6_d = new Subcategory();
        $subC6_d->setSubcategoryName('Pattern Two Variables');
        $subC6_d->setSubcategory('pattern-two-variables');
        $subC6_d->setIsSample(false);

        $subC6_e = new Subcategory();
        $subC6_e->setSubcategoryName('Symmetrical Patterns');
        $subC6_e->setSubcategory('symmetrical-patterns');
        $subC6_e->setIsSample(false);

        $cat6->setSub($subC6_a);
        $cat6->setSub($subC6_b);
        $cat6->setSub($subC6_c);
        $cat6->setSub($subC6_d);
        $cat6->setSub($subC6_e);
        $manager->persist($cat6);

        $cat7 = new Category();
        $cat7->setCategoryName("Time");
        $cat7->setCategory("time");

        $subC7_a = new Subcategory();
        $subC7_a->setSubcategoryName('Time');
        $subC7_a->setSubcategory('time');
        $subC7_a->setIsSample(false);

        $subC7_b = new Subcategory();
        $subC7_b->setSubcategoryName('Time Conversion');
        $subC7_b->setSubcategory('time-conversion');
        $subC7_b->setIsSample(false);

        $subC7_c = new Subcategory();
        $subC7_c->setSubcategoryName('Time Conversion AMPM');
        $subC7_c->setSubcategory('time-conversionAMPM');
        $subC7_c->setIsSample(false);

        $subC7_d = new Subcategory();
        $subC7_d->setSubcategoryName('TimeOperation');
        $subC7_d->setSubcategory('time-operation');
        $subC7_d->setIsSample(false);

        $cat7->setSub($subC7_a);
        $cat7->setSub($subC7_b);
        $cat7->setSub($subC7_c);
        $cat7->setSub($subC7_d);
        $manager->persist($cat7);

        $cat8 = new Category();
        $cat8->setCategoryName("Chart");
        $cat8->setCategory("chart");

        $subC8_a = new Subcategory();
        $subC8_a->setSubcategoryName('Bar Graph');
        $subC8_a->setSubcategory('bar-graph');
        $subC8_a->setIsSample(false);

        $subC8_b = new Subcategory();
        $subC8_b->setSubcategoryName('Pie Graph');
        $subC8_b->setSubcategory('pie-graph');
        $subC8_b->setIsSample(false);

        $cat8->setSub($subC8_a);
        $cat8->setSub($subC8_b);
        $manager->persist($cat8);

        //Flush Objects
        $manager->flush();

    }

} 