<?php
/**
 * Created by PhpStorm.
 * User: tetzel
 * Date: 10/23/15
 * Time: 11:18 PM
 */

namespace ZendTest\Log\Formatter;

use Zend\Log\Formatter\Json as JsonFormatter;


class JsonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideDateTimeFormats
     */
    public function testSetDateTimeFormat($dateTimeFormat)
    {
        $date = new \DateTime();
        $formatter = new JsonFormatter();
        $this->assertSame($formatter, $formatter->setDateTimeFormat($dateTimeFormat));
        $this->assertContains($dateTimeFormat, $formatter->getDateTimeFormat());
        $this->assertContains($date->format($dateTimeFormat), $formatter->format(['timestamp' => $date]));
    }

    public function provideDateTimeFormats()
    {
        return [
            ['r'],
            ['U'],
        ];
    }
}
