<?php

namespace AI\service;

interface CommandServiceInterface
{
    public function run(string $text): string;
}