<?php

namespace App\Service;

class DataFieldsEmptyChecker
{
    public function check(array $data): array
    {
        $validationResults = [];
        $requiredFields = ['email', 'name', 'sex', 'birthday', 'phone'];

        foreach ($requiredFields as $key) {
            if (!array_key_exists($key, $data)) {
                $validationResults[] = ['error' => "$key field is required!"];
            } elseif (empty($data[$key])) {
                $validationResults[] = ['error' => "$key field must not be empty"];
            }
        }

        return $validationResults;
    }
}
