<?php
/*
 * ========================================================================
 * Copyright (c) 2012 Vladislav "FractalizeR" Rastrusny
 * Website: http://www.fractalizer.ru
 * Email: FractalizeR@yandex.ru
 * ------------------------------------------------------------------------
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================================
 */

/**
 * Simple MySQL datareader
 */
class  FRDBS_DataReader_MySql implements FRDBS_DataReader_Interface {

    /**
     * @var resource
     */
    private $mysqlResult = false;

    /**
     * @var array
     */
    private $currentRow = false;

    /**
     * @param string $tableName Table name from which to read data
     * @param string $timeStampFieldName The field with timestamp on which we identify updated records
     * @param string $timestamp Timestamp value of the last synchronization
     */
    public function __construct($tableName, $timeStampFieldName, $timestamp) {
        $timestamp         = mysql_real_escape_string($timestamp);
        $this->mysqlResult = mysql_query("SELECT * FROM `$tableName` WHERE `$timeStampFieldName` > '$timestamp'");

        if (false === $this->mysqlResult) {
            throw new Exception("Error executing query: " . mysql_error());
        }

        $this->currentRow = mysql_fetch_assoc($this->mysqlResult);
    }

    /**
     * Destructor. Needed to close MySQL resources
     */
    public function __destruct() {
        mysql_free_result($this->mysqlResult);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current() {
        return $this->currentRow;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next() {
        $this->currentRow = mysql_fetch_assoc($this->mysqlResult);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return int scalar on success, integer
     * 0 on failure.
     */
    public function key() {
        return 0;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid() {
        return false !== $this->currentRow;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind() {
        //Stub. No rewinds
    }
}
