<?php

interface ResourceInterface
{
    public  function __construct(string $path);
    public function extract();
    public function row();
}
