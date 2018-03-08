<?php

namespace admin\gpio {


    interface GPIOInterface {
        /**
         * Get an input pin.
         *
         * @param int $number The pin number
         *
         * @return InputPinInterface
         */
        public function getInputPin($number);

        /**
         * Get an output pin.
         *
         * @param int $number The pin number
         *
         * @return OutputPinInterface
         */
        public function getOutputPin($number);

        /**
         * Create an interrupt watcher.
         *
         * @return InterruptWatcherInterface
         */
        public function createWatcher();
    }
}
