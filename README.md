# ConfigurationReader
Fast .ini parser. Framework independant. Allows reading .ini files using an
object oriented interface. Supports overloading configuration from multiple
.ini files.

## Usage
* PHP 5.3.* is required
* Create instance of ConfigurationReader passing list of files
* Read configuration options with get($option, $default) function

## Example
```php

use ElzeKool\ConfigurationReader\ConfigurationReader;

$config = new ConfigurationReader(array(
    
    'configuration/config.ini',
    // [group]
    // option1="value"
    // option2="value2"
    // option3[]="value3"
    // option3[]="value4"
    
    'configuration/test/config.ini',
    // Does not exist
    
    'configuration/development/config.ini'
    // [group]
    // option1="altvalue1"
    // option3[]="altvalue3"
    // option3[]="altvalue4"
    // option5="development"
));

var_dump($config->get('group.option1'));
// string(9) "altvalue1"

var_dump($config->get('group.doesnotexists', 'nope'));
// string(4) "nope"

print_r($config->get('group'));
// Array
// (
//    [option1] => altvalue1
//    [option2] => value2
//    [option3] => Array
//        (
//            [0] => altvalue3
//            [1] => altvalue4
//        )
// 
//     [option5] => development
// )


```


## License

(MIT License)

Copyright (c) 2013 Elze Kool <info@kooldevelopment.nl>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
