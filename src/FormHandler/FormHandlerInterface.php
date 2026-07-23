<?php

namespace App\FormHandler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface FormHandlerInterface
{
    public function handleForm(Request $request): Response|FormInterface;
}
