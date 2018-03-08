<?php

namespace admin\gpio {

    final class GPIO implements GPIOInterface {

        private $fileSystem;
        private $streamSelect;

        /**
         * Constructor.
         *
         * @param FileSystemInterface $fileSystem Optional file system object to use
         * @param callable $streamSelect Optional stream select callable
         */
        public function __construct(FileSystemInterface $fileSystem = null, callable $streamSelect = null) {
            $this->fileSystem = $fileSystem ?: new FileSystem();
            $this->streamSelect = $streamSelect ?: 'stream_select';
        }

        /**
         * {@inheritdoc}
         */
        public function getInputPin($number) {
            return new InputPin($this->fileSystem, $number);
        }

        /**
         * {@inheritdoc}
         */
        public function getOutputPin($number) {
            return new OutputPin($this->fileSystem, $number);
        }

        /**
         * {@inheritdoc}
         */
        public function createWatcher() {
            return new InterruptWatcher($this->fileSystem, $this->streamSelect);
        }
    }
}
