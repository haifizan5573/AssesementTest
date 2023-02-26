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

        $output = '';
        $uppercase = true;
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if ($char === ' ') {
                $output .= ' '; // include empty space in output
                continue; // skip to the next character
            }
            if ($uppercase) {
                $output .= strtoupper($char);
            } else {
                $output .= strtolower($char);
            }
            $uppercase = !$uppercase;
        }
        return $output;
    }

    public function toCsv($string)
    {
        $csv = Writer::createFromString('');
        // Set the delimiter and line ending
        $csv->setDelimiter(',');
        $csv->setNewline('');
        $csvData = str_split($string);
        //$csvDataString = implode(',', $csvData);
        //$csvDataString = $csvDataString . PHP_;
       // $csv->output($csvDataString , 'output.csv');
        $csv->insertOne($csvData);
        file_put_contents('string.csv', $csv->getContent());
    }

}
