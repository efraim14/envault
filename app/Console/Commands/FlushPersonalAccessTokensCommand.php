<?php

namespace App\Console\Commands;

use App\Models\PersonalAccessToken;
use Illuminate\Console\Command;

class FlushPersonalAccessTokensCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'personal-access-tokens:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush personal access tokens';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //For removing unused old Personal Access Tokens
        PersonalAccessToken::whereNotNull('last_used_at')->where('last_used_at', '<=', now()->subMonths(6))->delete();

        //For removing never used Personal Access Tokens
        PersonalAccessToken::whereNull('last_used_at')->where('created_at', '<=', now()->subMinutes(30))->delete();

        $this->info('Personal Access Tokens flushed successfully.');
    }
}
