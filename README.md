 GTool to  Zend Framework 2 Tool
================================

**GTool** It currently provides
the following functionality:

 * Module rename 

## Requirements

 * Zend Framework 2.0.0 RC1 or later.
 * PHP 5.3.3 or later.
 * Console access to the application being maintained (shell, command prompt)

## Installation
 
 1. Clone using `git` or [download zipball](https://github.com/benjamingb/GTool.git).
 1. Extract to `vendor/GTool` in your ZF2 application
 1. Edit your `config/application.config.php` and add `GTool` to `modules` array.
 1. Open console and try one of the following commands...

## Usage

### Basic information
    zf.php zfversion       display current Zend Framework version

### Rename Module

    zf.php rename <directoryModule> <NewName>

    <directoryModule>         The directory to scan for PHP classes (use "." to use current directory)
    <NewName>            File name for generated class map file  or - for standard output.If not supplied, defaults to autoload_classmap.php inside
                        <directory>.