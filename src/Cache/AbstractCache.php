<?php
    namespace Exteon\Patterns\Cache;

    use ArrayAccess;
    use ErrorException;
    use Iterator;

    abstract class AbstractCache implements ArrayAccess, Iterator, ICache
    {
        /**
         * @return mixed|null
         */
        public function current()
        {
            $this->setupRead();
            if($this->getKvStore()){
                return $this->getKvStore()->current();
            }
            return null;
        }

        public function next(): void
        {
            $this->setupRead();
            if($this->getKvStore()){
                $this->getKvStore()->next();
            }
        }

        /**
         * @return bool|float|int|string|null
         */
        public function key()
        {
            $this->setupRead();
            if($this->getKvStore()){
                return $this->getKvStore()->key();
            }
            return null;
        }

        /**
         * @return bool
         */
        public function valid(): bool
        {
            $this->setupRead();
            if($this->getKvStore()){
                return $this->getKvStore()->valid();
            }
            return false;
        }

        public function rewind(): void
        {
            $this->setupRead();
            if($this->getKvStore()){
                $this->getKvStore()->rewind();
            }
        }

        /**
         * @param mixed $offset
         * @return bool
         */
        public function offsetExists($offset): bool
        {
            $this->setupRead();
            if($this->getKvStore()){
                return $this->getKvStore()->offsetExists($offset);
            }
            return false;
        }

        /**
         * @param mixed $offset
         * @return mixed|null
         */
        public function offsetGet($offset)
        {
            $this->setupRead();
            if($this->getKvStore()){
                return $this->getKvStore()->offsetGet($offset);
            }
            return null;
        }

        /**
         * @param mixed $offset
         * @param mixed $value
         * @throws ErrorException
         */
        public function offsetSet($offset, $value): void
        {
            $this->setupWrite();
            if($this->getKvStore()){
                $this->getKvStore()->offsetSet($offset, $value);
            } else {
                throw new ErrorException('Cannot set cache value');
            }
        }

        /**
         * @param mixed $offset
         * @throws ErrorException
         */
        public function offsetUnset($offset): void
        {
            $this->setupWrite();
            if($this->getKvStore()){
                $this->getKvStore()->offsetUnset($offset);
            } else {
                throw new ErrorException('Cannot unset cache value');
            }
        }

        /**
         * #PHP8 Set union return type
         * @return ArrayAccess|Iterator|null
         */
        abstract protected function getKvStore();

        abstract protected function setupRead(): void;

        abstract protected function setupWrite(): void;
    }