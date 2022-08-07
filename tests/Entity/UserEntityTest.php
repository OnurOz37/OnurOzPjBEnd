<?php

namespace App\tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserEntityTest extends KernelTestCase
{
    private const EMAIL_CONSTRAINT_MESSAGE = 'The email \'"test@gmail"\' is not a valid email.';
    private const NOT_BLANK_CONSTRAINT_MESSAGE = "Veuillez saisir une valeur";
    private const INVALID_EMAIL_VALUE = "test@gmail";
    private const PASSWORD_REGEX_CONSTRAINT_MESSAGE = "Le mot de passe doit contenir au moins 1 majuscule, 1 miniscule, 1 chiffre 1 caractère spécial et une longueur de 10";
    private const VALID_EMAIL_VALUE = "test@gmail.com";
    private const VALID_PASSWORD_VALUE = "Sanane41!_";
    //private ValidatorInterface $validator;
    public $validator;

    protected function setUp():void
    {

        $kernel = self::bootKernel();

        //$this->validator = Validation::createValidatorBuilder()->addDefaultDoctrineAnnotationReader()->getValidator();
        $this->validator = $kernel->getContainer()->get('validator');

    }


    public function testUserEntityIsValid():void
    {
        $user = new User();

        $user->setEmail(self::VALID_EMAIL_VALUE)
            ->setPassword(self::VALID_PASSWORD_VALUE);

        $this->getValidationErrors($user, 1);

    }


    public function testUserEntityIsInvalidBecauseNoEmailEntered(): void
    {
        $user = new User();
        $user->setPassword(self::VALID_PASSWORD_VALUE);


        $errors = $this->getValidationErrors($user, 2);
        $this->assertEquals(self::NOT_BLANK_CONSTRAINT_MESSAGE, $errors[0]->getMessage());

    }



    public function testUserEntityIsInvalidBecauseNoPasswordEntered(): void
    {
        $user = new User();
        $user->setEmail(self::VALID_EMAIL_VALUE);



        $errors = $this->getValidationErrors($user, 2);
        $this->assertEquals(self::NOT_BLANK_CONSTRAINT_MESSAGE, $errors[0]->getMessage());

    }


    public function testUserEntityIsInvalidBecauseAnInvalidEmailHasBeenEntered(): void
    {
        $user = new User();
        $user->setEmail(self::INVALID_EMAIL_VALUE)
        ->setPassword(self::VALID_PASSWORD_VALUE);



        $errors = $this->getValidationErrors($user, 2);
        $this->assertEquals(self::EMAIL_CONSTRAINT_MESSAGE, $errors[0]->getMessage());

    }


    /**
     * @dataProvider provideInvalidPasswords
     */
    public function testUserEntityIsInvalidBecauseAnInvalidPasswordHasBeenEntered(string $invalidPassword): void
    {
        $user = new User();

        $user->setEmail(self::VALID_EMAIL_VALUE)
            ->setPassword($invalidPassword);

       $errors = $this->getValidationErrors($user, 2);
       $this->assertEquals(self::PASSWORD_REGEX_CONSTRAINT_MESSAGE, $errors[0]->getMessage());
    }

    public function provideInvalidPasswords(): array
    {
        return [
          ['Sananedu37'], //no special char
          ['Sananedu'], // no numbers
          ['Sanane41!'] , // -10 char
            ['sananedu41'], // miniscule
            ['SANANE41'] //majuscule
        ];
    }


    private function getValidationErrors(User $user, int $numberOfExpectedErrors): ConstraintViolationList
    {
        $errors = $this->validator->validate($user);

        $this->assertCount($numberOfExpectedErrors, $errors);

        return $errors;
    }

}
