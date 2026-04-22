<?php

namespace Sendama\Console\Strategies\AssetFileGeneration;

use Sendama\Console\Util\Path;

class MaterialFileGenerationStrategy extends AbstractAssetFileGenerationStrategy
{
    protected function configure(): void
    {
        if (!$this->fileExtension) {
            $this->fileExtension = '.material.php';
        }

        $nameTokens = explode('/', $this->filename);
        $this->classPath = to_pascal_case($this->directory);

        foreach ($nameTokens as $token) {
            $this->classPath = Path::join($this->classPath, to_kebab_case($token));
        }

        $this->className = basename($this->classPath);
        $this->relativeFilename = Path::join($this->assetsDirectoryName, $this->classPath . $this->fileExtension);
        $displayName = $this->buildDisplayName($this->className);

        $this->content = <<<PHP
<?php

return [
    'type' => 'physics',
    'name' => '{$displayName}',
    'friction' => 0.5,
    'bounciness' => 0.5,
];
PHP;
    }

    private function buildDisplayName(string $fileName): string
    {
        $normalized = trim(str_replace(['-', '_'], ' ', $fileName));

        if ($normalized === '') {
            return 'New Material';
        }

        return ucwords($normalized);
    }
}
