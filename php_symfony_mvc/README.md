php_mvc_symfony
===============

This is an symfony starter project pack with form types, validators and working database examples.

Used Namespaces:

Symfony\Component\Form\Extension\Core\Type\TextType

Symfony\Component\Form\Extension\Core\Type\DateTimeType

Symfony\Component\Form\Extension\Core\Type\SubmitType

Symfony\Component\Validator\Constraints\NotBlank

Symfony\Component\Validator\Constraints\Type


### Version
1.0.0

### Example usage

Generate a new Bundle:

run console: php bin/console generate:bundle --namespace=CompanyName/NameBundle

Add the budle to composer.json:

composer.json

..
"autoload": {
    "psr-4": {
        "CompanyName\\NameBundle\\": "src/CompanyName/NameBundle",
    }
..

run console: composer update

Add Template Path to Bundle-Folder if needed:

app/config/config.yaml

twig:
    paths: 
        '%kernel.project_dir%/src/CompanyName/NameBundle/Resources/views': NameBundle

