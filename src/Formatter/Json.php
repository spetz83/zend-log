<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Log\Formatter;

use Traversable;
use Zend\Escaper\Escaper;
use Zend\Stdlib\ArrayUtils;


class Json implements FormatterInterface
{
    /**
     * @var string Name of root element
     */
    protected $rootElement;

    /**
     * @var array Relates JSON elements to log data field keys
     */
    protected $elementMap;

    /**
     * @var string Encoding to use in JSON
     */
    protected $encoding;

    /**
     * @var Escaper instance
     */
    protected $escaper;

    /**
     * Format specifier for DateTime objects in event data (default: ISO 8601)
     *
     * @see http://php.net/manual/en/function.date.php
     * @var string
     */
    protected $dateTimeFormat = self::DEFAULT_DATETIME_FORMAT;

    /**
     * Class constructor
     * (the default encoding is UTF-8)
     * @param array|Traversable $options
     * @return Json
     */
    public function __construct($options = [])
    {
        if($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }

        if(!is_array($options)) {
            $args = func_get_args();

            $options = [
                'rootElement' => array_shift($args)
            ];

            if(count($args)) {
                $options['elementMap'] = array_shift($args);
            }

            if(count($args)) {
                $options['encoding'] = array_shift($args);
            }

            if(count($args)) {
                $options['dateTimeFormat'] = array_shift($args);
            }
        }

        if(!array_key_exists('rootElement', $options)) {
            $options['rootElement'] = 'logEntry';
        }

        if(!array_key_exists('encoding', $options)) {
            $options['encoding'] = 'UTF-8';
        }

        $this->rootElement = $options['rootElement'];
        $this->setEncoding($options['encoding']);

        if(array_key_exists('elementMap', $options)) {
            $this->elementMap = $options['elementMap'];
        }

        if(array_key_exists('dateTimeFormat', $options)) {
            $this->setDateTimeFormat($options['dateTimeFormat']);
        }
    }

    /**
     * Formats data into a single line to be written by the writer.
     *
     * @param array $event event data
     * @return string formatted line to write to the log
     */
    public function format($event)
    {

    }

    /**
     * Set Escaper instance
     *
     * @param Escaper $escaper
     * @return Json
     */
    public function setEscaper(Escaper $escaper)
    {
        $this->escaper = $escaper;
        return $this;
    }

    /**
     * Get Escaper instance
     *
     * Lazy-loads an instance with the current encoding if none registered.
     *
     * @return Escaper
     */
    public function getEscaper()
    {
        if(null === $this->escaper){
            $this->setEscaper(new Escaper($this->getEncoding()));
        }
        return $this->escaper;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeFormat()
    {
        return $this->dateTimeFormat;
    }

    /**
     * {@inheritdoc}
     */
    public function setDateTimeFormat($dateTimeFormat)
    {
        $this->dateTimeFormat = (string) $dateTimeFormat;
        return $this;
    }

    /**
     * Get Encoding
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Set Encoding
     * @param string $value
     * @return Json
     */
    public function setEncoding($value)
    {
        $this->encoding = $value;
        return $this;
    }
}