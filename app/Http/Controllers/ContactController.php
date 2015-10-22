<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ContactMeRequest;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

	/**
	 * Displays the contact view to be filled.
	 * 
	 * @return contact view
	 */
	public function showForm()
	{
		return view('blog.contact');
	}


	/**
	 * @param  ContactRequest request
	 * @return [view]
	 */
	public function sendContactInfo(ContactMeRequest $request)
	{
		$data = $request->only('name', 'email', 'phone');
    	$data['messageLines'] = explode("\n", $request->get('message'));

    	Mail::queue('emails.contact', $data, function ($message) use ($data) {
      		$message->subject('Blog Contact Form: '.$data['name'])
              ->to(config('blog.contact_email'))
              ->replyTo($data['email']);
    	});

    	return back()
        		->withSuccess("Thank you for your message. It has been sent.");
  	}
	
}
