<?php

namespace Sendama\Console\Commands;

use RuntimeException;
use Sendama\Console\Util\Path;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'new:game',
    description: 'Create a new game',
    aliases: ['new']
)]
class NewGame extends Command
{
  private bool $isVerbose = false;
  private ?OutputInterface $output = null;
  private ?InputInterface $input = null;

  // Directories
  /**
   * @var string The target directory.
   */
  private string $targetDirectory = '';
  /**
   * @var string The maps' directory.
   */
  private string $mapsDirectory = '';

  public function configure(): void
  {
    $this
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the game')
      ->addArgument('directory', InputArgument::OPTIONAL, 'The directory to create the game in', getcwd());
  }

  /**
   * @inheritDoc
   */
  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $this->input = $input;
    $this->output = $output;
    $this->isVerbose = $input->getOption('verbose');

    // Configure the target directory
    $output->writeln('Creating a new game...');
    $projectName = $input->getArgument('name');
    $this->targetDirectory = Path::join(
      $this->targetDirectory,
      $input->getArgument('directory'),
      strtolower(filter_string($projectName))
    );

    // Create project directory
    $this->createProjectDirectory();

    // Create project structure
    $this->log('Creating project structure...');

    $this->createLogsDirectory();
    $assetsDirectory = $this->createAssetsDirectory();
    $this->createAssetsScenesDirectory($assetsDirectory);
    $this->createAssetsScriptsDirectory($assetsDirectory);
    $this->createAssetsMapsDirectory($assetsDirectory);
    $this->createAssetsPrefabsDirectory($assetsDirectory);
    $this->createAssetsTexturesDirectory($assetsDirectory);

    // Create project files
    $this->log('Creating project files...');

    $this->createMainFile($projectName);
    $this->createDotEnvFile($this->targetDirectory);
    $this->createGitIgnoreFile($this->targetDirectory);
    $this->createSplashScreenTextureFile($assetsDirectory);
    $this->createPlayerTextureFile($assetsDirectory);
    $this->createTheExampleMapFile($this->mapsDirectory);

    // Create project configuration
    $this->createProjectConfiguration($projectName);

    // Done
    $this->log("\nDone! 🎮🎮🎮", true);

    // Tell user cd into the project directory
    $this->log("\nTo get started:", true);
    $this->log(sprintf("\n\033[2;37m\tcd %s/\e[0m", basename($this->targetDirectory)), true);
    $this->log(sprintf("\033[2;37m\tphp %s.php\e[0m\n", basename($this->targetDirectory)), true);

    return Command::SUCCESS;
  }

  private function log(string $message, bool $ignoreVerbose = false): void
  {
    if ($ignoreVerbose || $this->isVerbose)
    {
      $this->output?->writeln($message);
    }
  }

  /**
   * Ask the user to confirm an action.
   *
   * @param string $question The question to ask the user.
   * @param bool $default The default response. Default is false.
   * @return bool The user's response.
   */
  private function confirm(string $question, bool $default = false): bool
  {
    /** @var QuestionHelper $helper */
    $helper = $this->getHelper('question');
    $question = new ConfirmationQuestion($question, $default);

    return $helper->ask($this->input, $this->output, $question);
  }

  /**
   * Get the project configuration.
   *
   * @param string $packageName The package name.
   * @return string The project configuration.
   */
  private function getProjectConfiguration(string $packageName): string
  {
    [$organization, $projectName] = explode('/', $packageName);
    $namespace = to_title_case($organization) . '\\' . to_title_case($projectName) . '\\';

    return json_encode([
      'name' => $packageName,
      'version' => '1.0.0',
      'description' => 'A new 2D ASCII terminal game.',
      'type' => 'project',
      'require' => [
        'php' => '^8.3',
        'sendamaphp/engine' => '*'
      ],
      'require-dev' => [
        'pestphp/pest' => '^2.34',
        'phpstan/phpstan' => '^1.10',
      ],
      'autoload' => [
        'psr-4' => [
          $namespace => 'assets/'
        ]
      ],
      'config' => [
        'allow-plugins' => [
          'pestphp/pest-plugin' => true
        ]
      ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  }

  /**
   * Get the package name.
   *
   * @param string $default The default package name.
   * @return string The package name.
   */
  private function getPackageName(string $default): string
  {
    /** @var QuestionHelper $helper */
    $helper = $this->getHelper('question');
    $question = new Question(sprintf('Package name: (%s) ', $default), $default);

    $packageName = $helper->ask($this->input, $this->output, $question);

    $validPackageNamePattern = '/[a-zA-Z0-9_]+(-*[a-zA-Z0-9_]*)*\/[a-zA-Z0-9_]+(-*[a-zA-Z0-9_]*)*/';
    if (! preg_match($validPackageNamePattern, $packageName) )
    {
      throw new RuntimeException('Invalid package name');
    }

    return $packageName;
  }

  /**
   * Install the dependencies.
   *
   * @param string $targetDirectory The target directory.
   */
  private function installDependencies(string $targetDirectory): void
  {
    // Install dependencies
    $this->log('Installing dependencies...');
    if (false === `composer install --working-dir=$targetDirectory --ansi`)
    {
      throw new RuntimeException('Unable to install dependencies');
    }
  }

  /**
   * Create the project configuration.
   *
   * @param string $projectName The project name.
   */
  private function createProjectConfiguration(string $projectName): void
  {
    $projectName = strtolower(filter_string($projectName));
    $this->log('Creating project configuration...');
    $packageName = $this->getPackageName("sendama-engine/$projectName");

    $targetConfigFilename = Path::join($this->targetDirectory, 'composer.json');
    if (false === file_put_contents($targetConfigFilename, $this->getProjectConfiguration($packageName)))
    {
      throw new RuntimeException(sprintf('Unable to write to file "%s"', $targetConfigFilename));
    }

    if ($this->confirm('Would you like to install the dependencies? (Y/n) ', 'y') )
    {
      $this->installDependencies($this->targetDirectory);
    }
  }

  /**
   * Create the main file.
   *
   * @param mixed $projectName The project name.
   */
  private function createMainFile(string $projectName): void
  {
    $targetMainFilename = Path::join(
      $this->targetDirectory,
      basename($this->targetDirectory) . '.php'
    );
    $sourceMainFilename = Path::join(dirname(__DIR__, 2), 'templates', 'game.php');
    if (! copy($sourceMainFilename, $targetMainFilename) )
    {
      throw new RuntimeException(sprintf('File "%s" was not copied to "%s"', $sourceMainFilename, $targetMainFilename));
    }

    ## Replace the game name in the main file
    $mainFileContents = file_get_contents($targetMainFilename);
    $mainFileContents = str_replace('%GAME_NAME%', $projectName, $mainFileContents);
    if (false === file_put_contents($targetMainFilename, $mainFileContents))
    {
      throw new RuntimeException(sprintf('Unable to write to file "%s"', $targetMainFilename));
    }

  }

  /**
   * Create the splash screen texture file.
   *
   * @param string $assetsDirectory The assets' directory.
   */
  private function createSplashScreenTextureFile(string $assetsDirectory): void
  {
    $this->log('Creating splash screen texture file...');
    $targetSplashScreenTextureFilename = Path::join($assetsDirectory, 'splash.texture');

    ## Load the splash screen texture from assets/splash.texture
    $sourceSplashScreenTextureFilename = Path::join(dirname(__DIR__, 2), 'templates', 'assets', 'splash.texture');
    if (! copy($sourceSplashScreenTextureFilename, $targetSplashScreenTextureFilename) )
    {
      throw new RuntimeException(sprintf('File "%s" was not copied to "%s"', $sourceSplashScreenTextureFilename, $targetSplashScreenTextureFilename));
    }
  }

  /**
   * Create the example map file.
   *
   * @param string $mapsDirectory The maps' directory.
   */
  private function createTheExampleMapFile(string $mapsDirectory): void
  {
    $this->log('Creating example map file...');
    $targetExampleMapFilename = Path::join($mapsDirectory, 'example.tmap');
    $sourceExampleMapFilename = Path::join(dirname(__DIR__, 2), 'templates', 'assets', 'Maps', 'example.tmap');

    if (! copy($sourceExampleMapFilename, $targetExampleMapFilename) )
    {
      throw new RuntimeException(sprintf('File "%s" was not copied to "%s"', $sourceExampleMapFilename, $targetExampleMapFilename));
    }

  }

  /**
   * Create the assets' textures directory.
   *
   * @param string $assetsDirectory The assets' directory.
   */
  private function createAssetsTexturesDirectory(string $assetsDirectory): void
  {
    $texturesDirectory = Path::join($assetsDirectory, 'Textures');
    if (! mkdir($texturesDirectory) && ! is_dir($texturesDirectory))
    {
      throw new RuntimeException(sprintf('Directory "%s" was not created', $texturesDirectory));
    }
  }

  /**
   * Create the assets' prefabs directory.
   *
   * @param string $assetsDirectory The assets' directory.
   */
  private function createAssetsPrefabsDirectory(string $assetsDirectory): void
  {
    $prefabsDirectory = Path::join($assetsDirectory, 'Prefabs');
    if (! mkdir($prefabsDirectory) && ! is_dir($prefabsDirectory))
    {
      throw new RuntimeException(sprintf('Directory "%s" was not created', $prefabsDirectory));
    }
  }

  /**
   * Create the assets' maps directory.
   *
   * @param string $assetsDirectory The assets' directory.
   */
  private function createAssetsMapsDirectory(string $assetsDirectory): void
  {
    $this->mapsDirectory = Path::join($assetsDirectory, 'Maps');
    if (! mkdir($this->mapsDirectory) && ! is_dir($this->mapsDirectory))
    {
      throw new RuntimeException(sprintf('Directory "%s" was not created', $this->mapsDirectory));
    }
  }

  /**
   * Create the assets' scripts directory.
   *
   * @param string $assetsDirectory The assets' directory.
   */
  private function createAssetsScriptsDirectory(string $assetsDirectory): void
  {
    $scriptsDirectory = Path::join($assetsDirectory, 'Scripts');
    if (! mkdir($scriptsDirectory) && ! is_dir($scriptsDirectory))
    {
      throw new RuntimeException(sprintf('Directory "%s" was not created', $scriptsDirectory));
    }
  }

  /**
   * Create the assets' scenes directory.
   *
   * @param string $assetsDirectory The assets' directory.
   */
  private function createAssetsScenesDirectory(string $assetsDirectory): void
  {
    $scenesDirectory = Path::join($assetsDirectory, 'Scenes');
    if (! mkdir($scenesDirectory) && ! is_dir($scenesDirectory))
    {
      throw new RuntimeException(sprintf('Directory "%s" was not created', $scenesDirectory));
    }
  }

  /**
   * Create the assets' directory.
   *
   * @return string The assets' directory.
   */
  private function createAssetsDirectory(): string
  {
    $assetsDirectory = Path::join($this->targetDirectory, 'assets');
    if (! mkdir($assetsDirectory) && ! is_dir($assetsDirectory))
    {
      throw new RuntimeException(sprintf('Directory "%s" was not created', $assetsDirectory));
    }

    return $assetsDirectory;
  }

  /**
   * Create the logs' directory.
   */
  private function createLogsDirectory(): void
  {
    $logsDirectory = Path::join($this->targetDirectory, 'logs');
    if (! mkdir($logsDirectory) && ! is_dir($logsDirectory))
    {
      throw new RuntimeException(sprintf('Directory "%s" was not created', $logsDirectory));
    }
  }

  /**
   * Create the project directory.
   */
  private function createProjectDirectory(): void
  {
    $this->log('Creating project directory...');
    if (! mkdir($this->targetDirectory) && ! is_dir($this->targetDirectory))
    {
      throw new RuntimeException(sprintf('Directory "%s" was not created', $this->targetDirectory));
    }
  }

  /**
   * Create the player texture file.
   *
   * @param string $assetsDirectory The assets' directory.
   */
  private function createPlayerTextureFile(string $assetsDirectory): void
  {
    $this->log('Creating player texture file...');
    $targetPlayerTextureFilename = Path::join($assetsDirectory, 'Textures', 'player.texture');
    $sourcePlayerTextureFilename = Path::join(dirname(__DIR__, 2), 'templates', 'assets', 'Textures', 'player.texture');

    if (! copy($sourcePlayerTextureFilename, $targetPlayerTextureFilename) )
    {
      throw new RuntimeException(sprintf('File "%s" was not copied to "%s"', $sourcePlayerTextureFilename, $targetPlayerTextureFilename));
    }
  }

  /**
   * Create the .gitignore file.
   *
   * @param string $targetDirectory The target directory.
   */
  private function createDotEnvFile(string $targetDirectory): void
  {
    $this->log('Creating .env file...');
    $targetDotEnvFilename = Path::join($targetDirectory, '.env');
    $sourceDotEnvFilename = Path::join(dirname(__DIR__, 2), 'templates', '.env');

    if (! copy($sourceDotEnvFilename, $targetDotEnvFilename) )
    {
      throw new RuntimeException(sprintf('File "%s" was not copied to "%s"', $sourceDotEnvFilename, $targetDotEnvFilename));
    }
  }

  /**
   * Create the .gitignore file.
   *
   * @param string $targetDirectory The target directory.
   * @return void
   */
  private function createGitIgnoreFile(string $targetDirectory): void
  {
    $this->log('Creating .gitignore file...');
    $targetGitIgnoreFilename = Path::join($targetDirectory, '.gitignore');
    $sourceGitIgnoreFilename = Path::join(dirname(__DIR__, 2), 'templates', '.gitignore');

    if (! copy($sourceGitIgnoreFilename, $targetGitIgnoreFilename) )
    {
      throw new RuntimeException(sprintf('File "%s" was not copied to "%s"', $sourceGitIgnoreFilename, $targetGitIgnoreFilename));
    }
  }
}