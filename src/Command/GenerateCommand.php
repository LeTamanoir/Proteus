<?php

declare(strict_types=1);

namespace Proteus\Command;

use Proteus\Codegen;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GenerateCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('generate')
            ->setDescription('Generate PHP classes from Protobuf files')
            ->addOption(
                'proto',
                'p',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Path to the .proto file(s) to generate from (can be specified multiple times)'
            )
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Path to the output path (file or directory)'
            )
            ->addOption(
                'update-composer',
                null,
                InputOption::VALUE_NONE,
                'Update composer.json with the generated files'
            )
            ->setHelp(<<<'HELP'
The <info>generate</info> command generates PHP classes from Protobuf files.

<comment>Usage:</comment>
  proteus generate --proto test.proto --output Generated.php
  proteus generate -p test.proto -o Generated.php
  proteus generate -p file1.proto -p file2.proto -o src/generated/

<comment>Examples:</comment>
  proteus generate -p test.proto -o Generated.php
  proteus generate --proto test.proto --output src/Generated.php
  proteus generate -p file1.proto -p file2.proto -o src/generated/
HELP
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var array<string> $protoPaths */
        $protoPaths = $input->getOption('proto');
        /** @var string|null $outputPath */
        $outputPath = $input->getOption('output');
        $updateComposer = $input->getOption('update-composer');

        // Validate proto paths
        if (empty($protoPaths)) {
            $io->error('The --proto/-p option is required');
            return Command::FAILURE;
        }

        // Validate all proto files exist
        foreach ($protoPaths as $protoPath) {
            if (!file_exists($protoPath)) {
                $io->error("Proto file not found: {$protoPath}");
                return Command::FAILURE;
            }
        }

        // Resolve proto paths to absolute paths
        $protoPaths = array_map('realpath', $protoPaths);

        // Validate output path
        if ($outputPath === null) {
            $io->error('The --output/-o option is required');
            return Command::FAILURE;
        }

        $isOutputDir = count($protoPaths) > 1 || is_dir($outputPath);
        $outputDir = $isOutputDir ? $outputPath : dirname($outputPath);

        // Create output directory if needed
        if (!is_dir($outputDir)) {
            if (!mkdir($outputDir, 0755, true)) {
                $io->error("Could not create output directory: {$outputDir}");
                return Command::FAILURE;
            }
        }

        // Generate the code
        try {
            $generatedFiles = [];

            foreach ($protoPaths as $protoPath) {
                if ($isOutputDir) {
                    // Generate output filename based on proto filename
                    $protoBasename = pathinfo($protoPath, PATHINFO_FILENAME);
                    $outputFile = rtrim($outputPath, '/') . '/' . ucfirst($protoBasename) . '.php';
                } else {
                    $outputFile = $outputPath;
                }

                $io->writeln("Generating PHP classes from: {$protoPath}");
                Codegen::generate($protoPath, $outputFile);
                $io->success("Successfully generated: {$outputFile}");

                $generatedFiles[] = $outputFile;
            }

            $io->newLine();

            // Convert absolute paths to relative paths where possible
            $cwd = getcwd();
            if ($cwd === false) {
                $io->error('Could not determine current working directory');
                return Command::FAILURE;
            }

            $relativePaths = [];
            foreach ($generatedFiles as $file) {
                if (str_starts_with($file, $cwd . '/')) {
                    $relativePaths[] = substr($file, strlen($cwd) + 1);
                } else {
                    $relativePaths[] = $file;
                }
            }

            // Check if composer.json exists in current directory
            $composerJsonPath = $cwd . '/composer.json';
            if (file_exists($composerJsonPath)) {
                $shouldUpdateComposer = $updateComposer;

                if (!$shouldUpdateComposer) {
                    $question = new ConfirmationQuestion(
                        'Do you want to automatically add the generated files to composer.json? [Y/n] ',
                        true
                    );
                    $shouldUpdateComposer = $io->askQuestion($question);
                }

                if ($shouldUpdateComposer) {
                    // Read and parse composer.json
                    $composerContent = file_get_contents($composerJsonPath);
                    if ($composerContent === false) {
                        $io->error('Could not read composer.json');
                        return Command::FAILURE;
                    }

                    $composer = json_decode($composerContent, true);
                    if ($composer === null) {
                        $io->error('Could not parse composer.json');
                        return Command::FAILURE;
                    }

                    // Initialize autoload.classmap if it doesn't exist
                    if (!isset($composer['autoload'])) {
                        $composer['autoload'] = [];
                    }
                    if (!isset($composer['autoload']['classmap'])) {
                        $composer['autoload']['classmap'] = [];
                    }

                    // Add generated files to classmap (avoid duplicates)
                    foreach ($relativePaths as $path) {
                        if (!in_array($path, $composer['autoload']['classmap'], true)) {
                            $composer['autoload']['classmap'][] = $path;
                        }
                    }

                    // Write back to composer.json with pretty print
                    $newComposerContent = json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
                    file_put_contents($composerJsonPath, $newComposerContent);

                    $io->success('Updated composer.json');

                    // Run composer dump-autoload
                    $io->writeln('Running composer dump-autoload...');
                    $execOutput = [];
                    $returnCode = 0;
                    exec('composer dump-autoload 2>&1', $execOutput, $returnCode);

                    if ($returnCode === 0) {
                        $io->success('Successfully ran composer dump-autoload');
                    } else {
                        $io->warning('composer dump-autoload failed. Please run it manually.');
                        $io->writeln(implode("\n", $execOutput));
                    }
                } else {
                    $io->writeln("\nManually add the following to your composer.json:\n");
                    $io->writeln('  "autoload": {');
                    $io->writeln('    "classmap": [');
                    foreach ($relativePaths as $index => $path) {
                        $comma = $index < count($relativePaths) - 1 ? ',' : '';
                        $io->writeln("      \"{$path}\"{$comma}");
                    }
                    $io->writeln('    ]');
                    $io->writeln('  }');
                    $io->writeln("\nThen run: composer dump-autoload");
                }
            } else {
                $io->writeln('No composer.json found in current directory.');
                $io->writeln('Make sure to add the generated files to your autoloader:');
                $io->listing($relativePaths);
            }

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $io->error('Error: ' . $e->getMessage());
            if ($output->isVerbose()) {
                $io->writeln($e->getTraceAsString());
            }
            return Command::FAILURE;
        }
    }
}
