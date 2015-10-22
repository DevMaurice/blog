<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailController extends Controller{
public function Sending_Email()
{
   $this->call('GET','emails.test');
    return View('Email.test');
}

}