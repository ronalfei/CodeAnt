<?php
/**
* A simple counter
*
* @return    int
*/
function counter() 
{
    static $c = 0;
    return $c++;
}

// Create an instance of the Reflection_Function class
$func = new ReflectionFunction('counter');

// Print out basic information
printf(
    "===> The %s function '%s'\n".
    "     declared in %s\n".
    "     lines %d to %d\n",
    $func->isInternal() ? 'internal' : 'user-defined',
    $func->getName(),
    $func->getFileName(),
    $func->getStartLine(),
    $func->getEndline()
);

// Print documentation comment
printf("---> Documentation:\n %s\n", var_export($func->getDocComment(), 1));

// Print static variables if existant
if ($statics = $func->getStaticVariables())
{
    printf("---> Static variables: %s\n", var_export($statics, 1));
}

// Invoke the function
printf("---> Invokation results in: ");
var_dump($func->invoke());


// you may prefer to use the export() method
echo "\nReflectionFunction::export() results:\n";
echo '--------------<br/>';
echo ReflectionFunction::export('counter');
?> 