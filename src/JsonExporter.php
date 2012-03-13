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


class FRDBS_JsonExporter {

    public static function exportChanges(FRDBS_DataReader_Interface $dataReader, $filename) {
        $fileHandle = fopen($filename, 'wb');
        if (false === $fileHandle) {
            throw new Exception("Cannot open file '$filename'");
        }

        foreach ($dataReader as $data) {
            if (false === fwrite($fileHandle, json_encode($data) . "\r\n")) {
                throw new Exception("Error writting to file '$filename'");
            }
        }
        fclose($fileHandle);
    }
}
