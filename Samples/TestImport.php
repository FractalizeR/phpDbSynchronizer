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


require_once(__DIR__ . '/../src/Autoloader.php');

FRDBS_Autoloader::register();

mysql_connect('localhost', 'root', '');
mysql_select_db('smartsam_supp');


$writer   = new FRDBS_DataWriter_MySql('cards');
$importer = new FRDBS_JsonImporter();
$importer->importChanges($writer, __DIR__ . '/changes.txt');
