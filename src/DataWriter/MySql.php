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


class FRDBS_DataWriter_MySql implements FRDBS_DataWriter_Interface {

    /**
     * @var string
     */
    private $tableName;

    /**
     * @param string $tableName
     */
    public function __construct($tableName) {
        $this->tableName = $tableName;
    }

    /**
     * @param array $data
     */
    public function write(array $data) {
        $sql = $this->makeSQL($this->tableName, $data);
        if (false === mysql_query($sql)) {
            throw new Exception("Cannot execute query '$sql'!");
        }
    }

    /**
     * Forms an SQL operator in form $operator $tablename (fields...) VALUES (data...)
     *
     * Used in INSERT and REPLACE statements construction
     *
     * @static
     * @param string $tablename
     * @param array $data
     * @return array Generated SQL statement and data for it
     */
    protected static function makeSQL($tablename, array $data) {
        //Forming initial SQL skeleton INSERT INTO table(field1, field2,...) VAlUES(
        $sql = 'INSERT INTO `' . $tablename . "` \r\n(" . implode(', ', array_keys($data)) . ") \r\n VALUES (";

        //Now making a parameter for each field (field1 => :field1...)
        $sqlFieldParams = array();
        foreach ($data as $fieldValue) {
            $sqlFieldParams [] = "'" . mysql_real_escape_string($fieldValue) . "'";
        }

        //Listing params
        $sql .= implode(",\r\n", $sqlFieldParams);
        $sql .= ')';

        //ON DUPLICATE KEY UPDATE
        $sql .= ' ON DUPLICATE KEY UPDATE ';

        $sqlFieldParams = array();
        foreach ($data as $fieldName => $fieldValue) {
            $sqlFieldParams [] = "`$fieldName` = '" . mysql_real_escape_string($fieldValue) . "'";
        }

        $sql .= implode(",\r\n", $sqlFieldParams);

        return $sql;
    }
}