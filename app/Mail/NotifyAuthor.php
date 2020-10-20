<?php

namespace App\Mail;

//use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
//use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAuthor extends Mailable
{
	use SerializesModels;

	// protected $reviewerName;
	// protected $submissionTitle;
	// protected $expireDate;
	// protected $reviewerId;
	// protected $email;
    // protected $viewPassword;
    protected $sub_reviews_update;
    protected $rating;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(
		$sub_reviews_update,$rating
	) {
		// $this->sub_reviews_update = $sub_reviews_update;
		$this->sub_reviews_update = $sub_reviews_update;
		$this->rating = $rating;
		// $this->submissionTitle = $submissionTitle;
		// $this->submissionId = $submissionId;
		// $this->expireDate = $expireDate;
		// $this->reviewerId = $reviewerId;
		// $this->email = $email;
        // $this->viewPassword = $viewPassword;
        // echo 'constructor-------------->';
        // dd($this->sub_reviews_update);
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->markdown('mails.NotifyAuthor')->with([
			'sub_reviews_update' => $this->sub_reviews_update,
			'rating' => $this->rating
			// 'submissionTitle' => $this->submissionTitle,
			// 'submissionId' => $this->submissionId,
			// 'expireDate' => $this->expireDate,
			// 'reviewerId' => $this->reviewerId,
			// 'email'=> $this->email,
			// 'viewPassword'=> $this->viewPassword
		]);
	}
}
