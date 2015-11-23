<?php
/**
 * Created by PhpStorm.
 * User: tetzel
 * Date: 10/23/15
 * Time: 11:18 PM
 */

namespace ZendTest\Log\Formatter;

use DateTime;
use Zend\Log\Formatter\Json as JsonFormatter;


class JsonTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultFormat()
    {
        $date = new DateTime();
        $formatter = new JsonFormatter();
        $line = $formatter->format(['timestamp' => $date, 'message' => 'foo', 'priority' => 22]);

        $this->assertContains($date->format('c'), $line);
        $this->assertContains('foo', $line);
        $this->assertContains((string)22, $line);
    }

    public function testConfiguringElementMapping()
    {
        $formatter = new JsonFormatter('log', ['foo' => 'bar']);
        $line = $formatter->format(['bar' => 'baz']);
        $this->assertContains('{"log":{"foo":"baz"}}', $line);
    }

    /**
     * @dataProvider provideDateTimeFormats
     */
    public function testConfiguringDateTimeFormat($dateTimeFormat)
    {
        $date = new DateTime();
        $formatter = new JsonFormatter('log', null, 'UTF-8', $dateTimeFormat);
        $this->assertContains($date->format($dateTimeFormat), $formatter->format(['timestamp' => $date]));
    }

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
