<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Console\Commands\StrConverter;

class StrConverterTest extends TestCase
{
  
      /** @test */
      public function it_converts_string_to_uppercase()
      {
          $string = 'help forward';
          $converter = new StrConverter();
  
          $result = $converter->toUppercase($string);
  
          $this->assertEquals('HELP FORWARD', $result);
      }
  
      /** @test */
      public function it_converts_string_to_alternate_case()
      {
          $string = 'help forward';
          $converter = new StrConverter();
  
          $result = $converter->toAlternateCase($string);
  
          $this->assertEquals('HeLp FoRwArD', $result);
      }
  
      /** @test */
      public function it_creates_csv_from_string()
      {
          $string = 'help forward';
          $converter = new StrConverter();
  
          $converter->toCsv($string);
  
          $this->assertFileExists('string.csv');
          $this->assertEquals('h,e,l,p," ",f,o,r,w,a,r,d', trim(file_get_contents('string.csv')));
          
          // Clean up the created CSV file after the test
          unlink('string.csv');
      }

}
