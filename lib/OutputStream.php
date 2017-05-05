<?php

namespace Amp\ByteStream;

use Amp\Promise;

/**
 * An `OutputStream` allows writing data in chunks. Writers can wait on the returned promises to feel the backpressure.
 */
interface OutputStream {
    /**
     * Writes data to the stream.
     *
     * @param string $data Bytes to write.
     *
     * @return Promise Succeeds once the data has been successfully written to the stream.
     *
     * @throws ClosedException If the stream has already been closed.
     */
    public function write(string $data): Promise;

    /**
     * Marks the stream as no longer writable. Optionally writes a final data chunk before. Note that this is not the
     * same as forcefully closing the stream. This method waits for all pending writes to complete before closing the
     * stream. Socket streams implementing this interface should only close the writable side of the stream. Streams
     * implementing `InputStream` will need to additionally call `close()` to fully close the stream.
     *
     * @param string $finalData Bytes to write.
     *
     * @return Promise Succeeds once the data has been successfully written to the stream.
     *
     * @throws ClosedException If the stream has already been closed.
     */
    public function end(string $finalData = ""): Promise;

    /**
     * Closes the stream forcefully. Multiple `close()` calls are ignored. Successful streams should always be closed
     * via `end()`.
     *
     * Note: If a class implements `InputStream` and `OutputStream`, `close()` will close both streams at once. If you
     * want to allow half-closed duplex streams, you must use different objects for input and output.
     *
     * @return void
     */
    public function close();
}
