<?php
/**
 * SugarCLI
 *
 * PHP Version 5.3 -> 5.5
 * SugarCRM Versions 6.5 - 7.7
 *
 * @author Rémi Sauvat
 * @author Emmanuel Dyan
 * @author Joe Cora
 * @copyright 2005-2015 iNet Process
 * @copyright 2016 The New York Times
 *
 * @package inetprocess/sugarcrm
 *
 * @license Apache License 2.0
 *
 * @link http://www.inetprocess.com
 *
 * @since 1.11.1 Added baseModuleName method
 */

namespace SugarCli\Utils;

use Symfony\Component\Yaml\Dumper as YamlDumper;

/**
 * Various Utils
 */
class Utils
{
    /**
     * Create a new line every X words
     *
     * @param string  $sentence
     * @param integer $cutEvery
     *
     * @return string Same sentence cut
     */
    public static function newLineEveryXWords($sentence, $cutEvery)
    {
        // New line every 5 words
        $words = explode(' ', $sentence);
        $numWords = count($words);
        for ($i = 0; $i < $numWords; $i++) {
            $words[$i] = ($i !== 0 && $i%$cutEvery === 0 ? PHP_EOL : '') . $words[$i];
        }

        return implode(' ', $words);
    }

    /**
     * Generate a YAML file from an array
     *
     * @param array  $data
     * @param string $outputFile
     *
     * @throws \InvalidArgumentException
     */
    public static function generateYaml(array $data, $outputFile)
    {
        $outputFileDir = dirname($outputFile);
        if (!is_dir($outputFileDir)) {
            throw new \InvalidArgumentException("$outputFileDir is not a valid directory (" . __FUNCTION__ . ')');
        }

        $dumper = new YamlDumper();
        $dumper->setIndentation(4);
        $yaml = $dumper->dump($data, 3);
        file_put_contents($outputFile, $yaml);

        return true;
    }

    /**
     * Return the base module name with the prefix removed
     *
     * @author Joe Cora
     *
     * @param string $module_name
     * @requires |$module_name| > 0
     * @return string base module name
     */
    public static function baseModuleName($module_name)
    {
        // Perform regex to match pattern for Sugar module names with prefix defined
        preg_match('/^([a-zA-Z]{1,3}_){0,1}(.+)$/', $module_name, $matches);

        // Return the second match (1st is prefix; 2nd is base)
        return $matches[2];
    }
}
