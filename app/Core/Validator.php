<?php

namespace App\Core;

/**
 * Kelas Validator
 *
 * Validasi input form sederhana tanpa library eksternal.
 * Rules yang didukung:
 *   required, email, string, min:N, max:N,
 *   digits:N, unique:table[,col[,ignoreId]], in:a,b,c, date
 */
class Validator
{
    private $errors = [];

    /**
     * Validasi input berdasar rules.
     * Contoh: ['email' => 'required|email', 'password' => 'required|min:6']
     *
     * @param array $data     Data input (key => value)
     * @param array $rules    Map field => rule string
     * @param array $messages Custom error messages, key format: 'field.ruleName'
     */
    public function make($data, $rules, $messages = [])
    {
        foreach ($rules as $field => $ruleString) {
            $value      = $data[$field] ?? null;
            $fieldRules = explode('|', $ruleString);

            foreach ($fieldRules as $rule) {
                // Parse rule name & params  (e.g. "min:6" → name=min, params=[6])
                $params   = [];
                $ruleName = $rule;
                if (strpos($rule, ':') !== false) {
                    [$ruleName, $rawParams] = explode(':', $rule, 2);
                    $params = explode(',', $rawParams);
                }

                // Custom message key: "field.ruleName"
                $msg = $messages["{$field}.{$ruleName}"] ?? null;

                // --- required ---
                if ($ruleName === 'required') {
                    if ($value === null || $value === '' || (is_string($value) && trim($value) === '')) {
                        $this->addError($field, $msg ?: "Kolom {$field} wajib diisi.");
                    }
                    continue;
                }

                // Skip semua rule lain jika nilai kosong (nilai opsional)
                if ($value === null || $value === '') {
                    continue;
                }

                // --- email ---
                if ($ruleName === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, $msg ?: "Format email tidak valid.");
                }

                // --- string ---
                if ($ruleName === 'string' && !is_string($value)) {
                    $this->addError($field, $msg ?: "Kolom {$field} harus berupa teks.");
                }

                // --- min:N ---
                if ($ruleName === 'min' && isset($params[0]) && strlen((string) $value) < (int) $params[0]) {
                    $this->addError($field, $msg ?: "Kolom {$field} minimal {$params[0]} karakter.");
                }

                // --- max:N ---
                if ($ruleName === 'max' && isset($params[0]) && strlen((string) $value) > (int) $params[0]) {
                    $this->addError($field, $msg ?: "Kolom {$field} maksimal {$params[0]} karakter.");
                }

                // --- digits:N --- angka dengan panjang persis N
                if ($ruleName === 'digits' && isset($params[0])) {
                    if (!ctype_digit((string) $value) || strlen((string) $value) !== (int) $params[0]) {
                        $this->addError($field, $msg ?: "Kolom {$field} harus terdiri dari {$params[0]} digit angka.");
                    }
                }

                // --- in:a,b,c ---
                if ($ruleName === 'in' && !in_array($value, $params, true)) {
                    $this->addError($field, $msg ?: "Nilai {$field} tidak valid.");
                }

                // --- date ---
                if ($ruleName === 'date' && strtotime((string) $value) === false) {
                    $this->addError($field, $msg ?: "Kolom {$field} bukan tanggal yang valid.");
                }

                // --- unique:table[,column[,ignoreId]] ---
                if ($ruleName === 'unique') {
                    $table    = $params[0] ?? '';
                    $col      = $params[1] ?? $field;
                    $ignoreId = $params[2] ?? null;
                    if ($table) {
                        try {
                            $q = \Illuminate\Database\Capsule\Manager::table($table)->where($col, $value);
                            if ($ignoreId !== null) {
                                $q = $q->where('id', '!=', $ignoreId);
                            }
                            if ($q->exists()) {
                                $this->addError($field, $msg ?: "Data {$field} ini sudah terdaftar.");
                            }
                        } catch (\Exception $e) {
                            // jika tabel tidak ditemukan, skip unique check
                        }
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
