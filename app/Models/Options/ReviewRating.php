<?php

namespace App\Models\Options;

use Illuminate\Database\Eloquent\Model;

class ReviewRating extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'review_ratings';

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];
}
