<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Writer;

class StrConverter extends Command
{


    protected $signature = 'convert {string} {--uppercase} {--alternate} {--csv}';

    protected $description = 'Convert a string to uppercase, alternate case, or CSV.';


    public function handle()
    {
        $string = $this->argument('string');
        $converter = new StrConverter($string);

        if ($this->option('uppercase')) {
            $this->line($converter->toUppercase($string));
        }

        if ($this->option('alternate')) {
            $this->line($converter->toAlternateCase($string));
        }

        if ($this->option('csv')) {
            $converter->toCsv($string);
            $this->line('CSV created!');
        }
    }

    public function toUppercase($string)
    {
        return strtoupper($string);
    }

    public function toAlternateCase($string)
    {
        return preg_replace_callback('/./', function($match) {
            return ord($match[0]) % 2 == 0 ? strtoupper($match[0]) : strtolower($match[0]);
        }, $string);
    }

    public function toCsv($string)
    {
        $csv = Writer::createFromString('');
        $csv->insertOne(str_split($string));
        file_put_contents('string.csv', $csv->getContent());
    }
}
