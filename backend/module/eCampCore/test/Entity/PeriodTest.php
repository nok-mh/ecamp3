<?php

namespace eCamp\CoreTest\Entity;

use eCamp\Core\Entity\Camp;
use eCamp\Core\Entity\Day;
use eCamp\Core\Entity\Period;
use eCamp\Core\Entity\ScheduleEntry;
use eCamp\LibTest\PHPUnit\AbstractTestCase;

/**
 * @internal
 */
class PeriodTest extends AbstractTestCase {
    public function testCamp() {
        $camp = new Camp();

        $start = new \DateTime();
        $start->setTime(0, 0, 0);
        $end = clone $start;
        $end->add(new \DateInterval('P7D'));
        $end->setTime(23, 59, 59);

        $period = new Period();
        $period->setCamp($camp);
        $period->setDescription('PeriodDesc');
        $period->setStart($start);
        $period->setEnd($end);

        $this->assertEquals($camp, $period->getCamp());
        $this->assertEquals('PeriodDesc', $period->getDescription());
        $this->assertEquals($start, $period->getStart());
        $this->assertEquals($end, $period->getEnd());
    }

    public function testStartEnd() {
        $start = new \DateTime();
        $start->setTime(0, 0, 0);
        $end = clone $start;
        $end->add(new \DateInterval('P7D'));
        $end->setTime(23, 59, 59);

        $period = new Period();
        $period->setStart($end);
        $period->setEnd($start);
        $this->assertEquals($start, $period->getStart());

        $period = new Period();
        $period->setEnd($start);
        $period->setStart($end);
        $this->assertEquals($end, $period->getEnd());
    }

    public function testDuration() {
        $start = new \DateTime();
        $start->setTime(0, 0, 0);
        $end = clone $start;
        $end->add(new \DateInterval('P7D'));
        $end->setTime(23, 59, 59);

        $period = new Period();
        $this->assertEquals(0, $period->getDurationInDays());
        $period->setStart($start);
        $this->assertEquals(0, $period->getDurationInDays());
        $period->setEnd($end);
        $this->assertEquals(8, $period->getDurationInDays());
    }

    public function testDay() {
        $period = new Period();
        $day = new Day();

        $this->assertEquals(0, $period->getDays()->count());
        $period->addDay($day);
        $this->assertContains($day, $period->getDays());
        $period->removeDay($day);
        $this->assertEquals(0, $period->getDays()->count());
    }

    public function testScheduleEntry() {
        $period = new Period();
        $scheduleEntry = new ScheduleEntry();

        $this->assertEquals(0, $period->getScheduleEntries()->count());
        $period->addScheduleEntry($scheduleEntry);
        $this->assertContains($scheduleEntry, $period->getScheduleEntries());
        $period->removeScheduleEntry($scheduleEntry);
        $this->assertEquals(0, $period->getScheduleEntries()->count());
    }

    public function testLifecycle() {
        $period = new Period();
        $period->PrePersist();
        $period->PreUpdate();

        $this->assertInstanceOf(Period::class, $period);
    }
}
