<?php

namespace App\System;

/**
 * Class View
 * @package App\System
 */
class View
{
    /**
     * const with template path
     */
    private const TEMPLATE_PATH = 'view';
    /**
     * @var string
     */
    private $folder;
    /**
     * @var array
     */
    private $parts = [];

    /**
     * @param array|null $data
     * @return null|string
     */
    public function render(array $data = null): ?string
    {
        $result = null;
        foreach ($this->parts as $part) {
            echo $this->renderPart($part, $data);				
        }
        return $result;
    }

    /**
     * @param string $partname
     */
    public function addPart(string $partname): void
    {
        $this->parts[] = BASE_PATH . DS . self::TEMPLATE_PATH . DS . ($this->folder ? (DS . $this->folder . DS) : '') . $partname . '.view.php';
    }

    /**
     * @param string $filepath
     * @param array $data
     * @return string
     */
    protected function renderPart(string $filepath, array $data): string
    {
        if (file_exists($filepath)) {
            extract($data, EXTR_OVERWRITE);
            ob_start();
            require $filepath;
        }
        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return Application::getInstance()->getBaseUrl();
    }
}