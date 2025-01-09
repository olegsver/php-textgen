<?php

namespace AI\service;

class LearnService implements CommandServiceInterface
{
    private ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public const DEFAULT_N_GRAM = 5;

    public function run(string $text): string
    {
        // Handle empty or too short input
        if (empty(trim($text))) {
            return "Error: Input text is empty. Cannot train the model.\n";
        }

        $n     = self::DEFAULT_N_GRAM;
        $chars = str_split($text);

        if (count($chars) < $n + 1) {
            return "Error: Input text must be at least " . ($n + 1) . " characters long.\n";
        }

        // Prepare the training data (samples and targets)
        $samples = [];
        $targets = [];

        // Generate n-grams and corresponding targets
        for ($i = 0; $i < count($chars) - $n; $i++) {
            $ngram = array_slice($chars, $i, $n); // Get the n-gram
            // Convert each character to its ASCII value using ord()
            $samples[] = array_map(fn($char) => ord($char), $ngram); // Map chars to numbers
            $targets[] = ord($chars[$i + $n]); // Predict the next character using ord()
        }

        // Train the model with the new data
        $this->modelService->train($samples, $targets);

        // Save the model
        try {
            $this->modelService->save();
        } catch (\Exception $e) {
            return "Error: Unable to save the model. " . $e->getMessage() . "\n";
        }

        return "Model trained and updated successfully.\n";
    }
}