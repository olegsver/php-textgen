<?php

namespace AI\service;

class PredictService implements CommandServiceInterface
{
    private ModelService $modelService;

    private const ITERATIONS = 10;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function run(string $text): string
    {
        // Check if the text is long enough to begin predictions
        if (strlen($text) < LearnService::DEFAULT_N_GRAM) {
            return sprintf(
                "Input text must be at least %d characters long for predictions.", LearnService::DEFAULT_N_GRAM
            );
        }

        // Perform iterative prediction
        for ($i = 0; $i < self::ITERATIONS; $i++) {
            $nextChar = $this->predictNext($text);
            $text     .= $nextChar; // Append the predicted character to the input
        }

        return "Next text: '$text'.";
    }

    private function predictNext(string $text): string
    {
        $n = LearnService::DEFAULT_N_GRAM; // Size of the n-gram, matching the training data

        // Ensure the input is at least $n characters long for prediction
        if (strlen($text) < $n) {
            return "Input must be at least $n characters long.";
        }

        // Take the last $n characters for prediction context
        $context = substr($text, -$n);

        // Convert input characters to numeric values (ASCII values)
        $inputEncoded = array_map('ord', str_split($context));

        // Predict the next character
        $predictedNum = $this->modelService->predictNext($inputEncoded);

        // Ensure the predicted number is within the printable ASCII range
        if ($predictedNum < 32 || $predictedNum > 126) {
            // Map to a space if the prediction is out of range
            $predictedNum = 32;
        }

        // Convert the predicted number back to a character
        return chr($predictedNum);
    }
}