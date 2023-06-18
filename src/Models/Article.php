<?php

namespace src\Models;

require_once 'Model.php';

/**
 * @property int $id
 * @property string $title
 * @property string $url
 * @property int $author_id
 */
class Article extends Model {

    // Add properties and methods here
    // Something like an $id, $title and $url would be reasonable
    // Refer to lab 2 for a similar model implementation

    private int $id;
    private string $title;
    private string $url;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Article
     */
    public function setId(int $id): Article
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Article
     */
    public function setTitle(string $title): Article
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Article
     */
    public function setUrl(string $url): Article
    {
        $this->url = $url;
        return $this;
    }
}
