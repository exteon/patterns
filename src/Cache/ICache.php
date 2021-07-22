<?php
    namespace Exteon\Patterns\Cache;

    use ArrayAccess;

    interface ICache extends ArrayAccess
    {
        /**
         * @return bool
         */
        public function exists(): bool;

        public function purge(): void;
    }