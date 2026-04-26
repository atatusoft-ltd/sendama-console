<?php

namespace Sendama\Console\Editor;

final class MaterialWriter
{
    public function save(string $materialPath, array $materialData): bool
    {
        return file_put_contents($materialPath, $this->serialize($materialData)) !== false;
    }

    public function serialize(array $materialData): string
    {
        $normalizedMaterial = [
            'type' => 'physics',
            'name' => $this->normalizeName($materialData['name'] ?? null),
            'friction' => $this->normalizeUnitFloat($materialData['friction'] ?? 0.5),
            'bounciness' => $this->normalizeUnitFloat($materialData['bounciness'] ?? 0.5),
        ];

        return "<?php\n\nreturn " . var_export($normalizedMaterial, true) . ";\n";
    }

    private function normalizeName(mixed $value): string
    {
        $name = is_string($value) ? trim($value) : '';

        return $name !== '' ? $name : 'New Material';
    }

    private function normalizeUnitFloat(mixed $value): float
    {
        $numericValue = is_int($value) || is_float($value)
            ? (float) $value
            : (float) (is_string($value) ? trim($value) : 0.5);

        return max(0.0, min(1.0, $numericValue));
    }
}
