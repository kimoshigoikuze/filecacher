<?php

namespace App;

use App\Interfaces\CacheInterface;
use Exception;

class FileCache implements CacheInterface
{
    private $fileName;

    public function __construct($name)
    {
        $this->fileName = sprintf('%s/../%s', __DIR__, $name);

        if (!file_exists($this->fileName)) {
            fopen($this->fileName, 'w') or die('Cannot create file');
        }
    }

    public function set(string $key, $value, int $duration)
    {
        $data = serialize($value);
        $until = time() + ($duration * 60);
        $this->append("START$key-$data|||$until-END$key");
    }

    private function append(string $block)
    {
        try {
            $file = file_get_contents($this->fileName);
            file_put_contents($this->fileName, $block . $file, LOCK_EX);
        } catch (Exception $exception) {
            echo 'Caught exception: ', $exception->getMessage(), "\n";
        }
    }

    public function get(string $key)
    {
        $data = $this->find($key);

        if ($data != null) {

            $data = unserialize($data);
        }

        return $data;
    }

    /**
     *TODO:: Refactor/split
     */
    private function find(string $key)
    {
        $response = null;

        try {
            $file = file_get_contents($this->fileName);

            $startNeedle = "START$key-";

            $entryStart = strpos($file, $startNeedle);

            if ($entryStart !== false) {

                $endNeedle = "-END$key";
                $delimiter = "|||";

                $entryEnd = strpos($file, $endNeedle);
                $payloadStart = $entryStart + strlen($startNeedle);

                $mixedContent = substr($file, $payloadStart, $entryEnd - $payloadStart);
                $delimiterPos = strpos($mixedContent, $delimiter);

                $body = substr($mixedContent, 0, $delimiterPos);
                $until = substr($mixedContent, $delimiterPos + strlen($delimiter));

                if ($until >= time()) {
                    $response = $body;
                } else {
                    $before = substr($file, 0, $entryStart);
                    $after = substr($file, $entryEnd + strlen($endNeedle));

                    file_put_contents($this->fileName, $before . $after, LOCK_EX);
                }
            }
        } catch (Exception $exception) {
            echo 'Caught exception: ', $exception->getMessage(), "\n";
        }

        return $response;
    }
}
