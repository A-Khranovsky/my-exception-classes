<?php

class AttributeException extends Exception
{
    public function __construct(
        $attribute,
        $message = 'Аттрибут %s не определен'
    ) {
        $message = sprintf($message, $attribute);
        parent::__construct($message, 1001);
    }
}

class PasswordException extends Exception
{
    public function __construct(
        $message = 'Не допускается прямого доступа к аттрибуту password'
    ) {
        parent::__construct($message, 1002);
    }
}

class User
{
    public $first_name, $last_name, $email, $password;

    public function __construct(
        $email,
        $password,
        $first_name = null,
        $last_name = null
    ) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
    }

    public function __get($index)
    {
        if ($index == 'password') {
            throw new PasswordException();
        }
        if (isset($this->index)) {
            return $this->index;
        } else {
            throw new AttributeException($index);
        }
    }

    public function __set($index, $value)
    {
        if (isset($this->index)) {
            $this->index = $value;
        } else {
            throw new AttributeException($index);
        }
    }

    public function isPasswordCorrect($password)
    {
        return $this->password == $password;
    }
}

try {
    $user = new User(
        'alex@ukr.net',
        'qwerty',
        'Alex',
        'Alex'
    );
    //echo $user->password;
    echo $user->value = 'qqq';
} catch (Exception $e) {
    echo $str = "Исключение: {$e->getMessage()}<br />" .
    "В файле: {$e->getFile()}<br />" .
    "В строке: {$e->getLine()}<br />" .
    "<pre>" .
    $e->getTraceAsString() .
    "</pre>";

    $str = str_replace(['<br />','<pre>','</pre>'], [PHP_EOL,'',PHP_EOL], $str);
    $str .= PHP_EOL;
    file_put_contents(__DIR__ . '\exceptions.log', $str, FILE_APPEND);
}
