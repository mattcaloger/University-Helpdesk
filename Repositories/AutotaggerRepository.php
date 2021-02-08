<?php

    class AutotaggerRepository {
        public static function Autotag($summary, $description) {
            $combinedText = filter_var($summary, FILTER_SANITIZE_STRING) . " " . filter_var($description, FILTER_SANITIZE_STRING);
            $explodedText = explode(" ", $combinedText);

            
        }
    }

?>