# Sendama CLI &mdash; Console Application for the Sendama 2D Game Engine
by amasiye313@gmail.com

## What is it?

Sendama CLI is a console application that provides a command line interface for the Sendama 2D Game Engine. It is used to create, build, run and manage Sendama projects.

## Requirements

- PHP 8.3 or newer
- WSL (For Windows)
- Composer 2.7.1 or later
- Sendama 2D Game Engine

## Installation

### For Linux, BSD etc
```bash
composer global require sendamaphp/cli
```

### For Windows
From the WSL terminal follow Linux instructions

### OSX
```bash
composer global require sendamaphp/cli
```

## Usage
```bash
sendama [command] [options] [arguments]
```

### Options
- `--help` or `-h` displays help for the command
- `--quiet` or `-q` suppresses output
- `--verbose` or `-v|vv|vvv` increases output verbosity
- `--version` or `-V` displays the application version
- `--ansi` or `-a` forces ANSI output
- `--no-ansi` or `-A` disables ANSI output
- `--no-interaction` or `-n` disables interaction

### Available Commands

#### Completion

Dump shell completion code for the specified shell (bash, fish, zsh, or PowerShell).
```bash
sendama completion
```

#### Help

Displays help for a command
```bash
sendama help
```

#### List

Lists commands
```bash
sendama list
```

#### Create a new project

Create a new Sendama project
```bash
sendama new:game mygame
```
or
```bash
sendama new mygame
```

#### Arguments
- `name` is the name of the project
- `directory` is the path to the project directory

### Generate a new scene
```bash
sendama generate:scene myscene
```

### Generate a new texture
```bash
sendama generate:texture mytexture
```

#### Generate a new texture with a specific size
```bash
sendama generate:texture mytexture --width=32 --height=32
```