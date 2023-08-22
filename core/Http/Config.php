<?php

namespace Core\Http;

trait Config
{
    protected $allowed_extensions = ['txt', 'pdf', 'jpg', 'png', 'xlsx', 'docx', 'pptx'];
    protected $max_size = 5120;
}