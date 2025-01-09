<?php

namespace AI\service;

use Phpml\Classification\KNearestNeighbors;
use Phpml\Estimator;
use Phpml\ModelManager;

class ModelService
{
    private ModelManager $manager;

    private Estimator $model;

    private const MODEL_PATH = __DIR__ . '/../model/saved_model.phpml';

    public function __construct()
    {
        $this->manager = new ModelManager();
        if (!file_exists(self::MODEL_PATH)) {
            $this->model = new KNearestNeighbors();
        } else {
            $this->model = $this->manager->restoreFromFile(self::MODEL_PATH);
        }
    }

    public function convertCharToNum(string $char): int
    {
        return ord($char); // Convert char to ASCII number
    }

    public function convertNumToChar(int $num): string
    {
        return chr($num); // Convert number back to char
    }

    public function train(array $samples, array $targets): void
    {
        $this->model->train($samples, $targets);
    }

    public function predictNext(array $inputEncoded): int
    {
        return $this->model->predict([$inputEncoded])[0]; // Predict next character index
    }

    public function save(): void
    {
        $this->manager->saveToFile($this->model, self::MODEL_PATH);
    }
}