<?php

namespace Cards\Validation;

use Symfony\Component\Validator\Constraints as Assert;

class CardValidation
{
    private $validator;
    private $data = [];
    private $errors = [];

    public function __construct($validator, $data) {
        $this->validator = $validator;
        $this->data = $data;

        $this->validate();
    }

    private function validate() {
        $constraint = new Assert\Collection([
            'receiver' => new Assert\Collection([
               'name' => new Assert\NotBlank(),
               'email' => new Assert\Email(),
            ]),
            'sender' => new Assert\Collection([
               'name' => new Assert\NotBlank(),
               'email' => new Assert\Email(),
            ]),
            'message' => new Assert\NotBlank(),
        ]);

        $errors = $this->validator->validateValue($this->data, $constraint);
        foreach ($errors as $error) {
            $this->errors[] = $error->getPropertyPath() . ': ' . $error->getMessage();
        }
    }

    public function getErrors() {
        return $this->errors;
    }
}