<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Post\PostRepositoryInterface;

class CheckPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:post';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post news every minutes';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->postRepository->taskSchedule();
    }
}
