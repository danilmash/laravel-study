<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;

class ArticlePosted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $article;
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function build()
    {
        return $this->from(env('MAIL_USERNAME'))
                    ->view('mail.article_posted')
                    ->with(['article'=>$this->article]);;
    }
}
