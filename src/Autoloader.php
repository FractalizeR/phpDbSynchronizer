<?php

/*
 * ========================================================================
 * Copyright (c) 2011 Vladislav "FractalizeR" Rastrusny
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
 * Simple autoloader for phpSweetPDO
 */
class FRDBS_Autoloader {

    public static function load($className) {
        if (strpos($className, "FRDBS") !== 0) {
            return;
        }

        $dirs = explode('_', $className);
        unset($dirs[0]);

        require_once(__DIR__ . '/' . implode(DIRECTORY_SEPARATOR, $dirs) . '.php');
    }

    public static function register() {
        spl_autoload_register(__CLASS__ . '::load');
    }

}
