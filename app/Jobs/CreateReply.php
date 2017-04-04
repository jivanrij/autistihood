<?php

namespace App\Jobs;

use App\Http\Requests\ReplyRequest;
use App\Models\Reply;
use App\Models\ReplyAble;
use App\User;

class CreateReply
{
    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var \App\User
     */
    private $author;

    /**
     * @var \App\Models\ReplyAble
     */
    private $replyAble;

    public function __construct(string $body, string $ip, User $author, ReplyAble $replyAble)
    {
        $this->body = $body;
        $this->ip = $ip;
        $this->author = $author;
        $this->replyAble = $replyAble;
    }

    public static function fromRequest(ReplyRequest $request): self
    {
        return new static($request->body(), $request->ip(), $request->author(), $request->replyAble());
    }

    public function handle(): Reply
    {
        $reply = new Reply(['body' => $this->body, 'ip' => $this->ip]);
        $reply->authoredBy($this->author);
        $reply->to($this->replyAble);
        $reply->save();

        return $reply;
    }
}
