<?php

namespace App\Core;

/**
 * Kelas Validator
 * 
 * Validasi input form secara sederhana tanpa library eksternal.
 */
class Validator
{
    private $errors = [];

    /**
     * Validasi input berdasar rules
     * Contoh rule: ['email' => 'required|email', 'password' => 'required|min:6']
     */
    public function make($data, $rules)
    {
        foreach ($rules as $field => $ruleString) {
            $value = $data[$field] ?? null;
            $fieldRules = explode('|', $ruleString);

            foreach ($fieldRules as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $this->addError($field, "Kolom {$field} wajib diisi.");
                }

                if ($rule === 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "Format email tidak valid.");
                }

                if (strpos($rule, 'min:') === 0 && !empty($value)) {
                    $min = (int) str_replace('min:', '', $rule);
                    if (strlen($value) < $min) {
                        $this->addError($field, "Kolom {$field} minimal {$min} karakter.");
                    }
                }
            }
        }

        return count($this->errors) === 0;
    }

    private function addError($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    public function errors()
    {
        return $this->errors;
    }
}
