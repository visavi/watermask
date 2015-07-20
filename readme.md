# System control data are stored in text format

[![Latest Stable Version](https://poser.pugx.org/visavi/flystring/v/stable)](https://packagist.org/packages/visavi/flystring)
[![Total Downloads](https://poser.pugx.org/visavi/flystring/downloads)](https://packagist.org/packages/visavi/flystring)
[![Latest Unstable Version](https://poser.pugx.org/visavi/flystring/v/unstable)](https://packagist.org/packages/visavi/flystring)
[![License](https://poser.pugx.org/visavi/flystring/license)](https://packagist.org/packages/visavi/flystring)

Basic useful feature list:

 * Reading and retrieval of data in a text file
 * Adding and deleting rows
 * Shift, rotation, clear and moving strings
 * Verifying the existence and size of the output file
 * Suitable for working with CSV format

```php
<?php
// Pass the file name and separator (default |)
$fly = new Visavi\FlyString('test.txt', '|');

// Checks the existence of the line returns true or false
$string = $fly->exists();

// Returns the number of lines in the file, if the file does not exist returns 0
$string = $fly->count();

// Adding lines to the file, if the file does not exist it will be created, line is added to the file
$fly->insert(['hello', 'world', 'test', 555]);

// Add a line to the beginning of the file
$fly->insert([0, 'The line at the beginning of the', 'something'], false);

// Reading the first line of the file, Default shows the last line in the file
$string = $fly->read(0);

// Search the data in cell number 2, it returns an array of the entire row and line number
$string = $fly->search(2, 'test');

// Change the value in the line number 8 and the cell number 2
$fly->cell(8, 2, 'new value');

// Writes a string number 5 new data
$fly->update(5, ['hello', 'world', 'test', 555]);

// Line breaks down the file number 3, if no number is transferred to a null string
$fly->down(3);

// Shift 7 line 1 position up, then there would be 7 line 6 and vice versa
$fly->shift(7, -1);

// Deleting rows from a file, instead of an array can be passed an integer
$string = $fly->delete([1, 2]);

// Rewrites the entire file when the file does not exist, create it
$fly->write('new file');

// Displays formatted file size, such as 543B, 1.43kB
$fly->filesize();

// Clears file
$fly->clear();
```

### Installing

```
composer require visavi/flystring
```

### License

The class is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
