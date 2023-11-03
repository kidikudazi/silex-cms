<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PasswordReset;
use Carbon\Carbon;

class ExpiredPasswordToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove expired password tokens';

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
        # password recovery links
        $recoveryLinks = PasswordReset::orderBy('created_at', 'DESC')->get();

        # filter links and delete link older than 2hours
        foreach ($recoveryLinks as $link) {

            # time interval difference
            $now = Carbon::now();
            $linkSentAt = $link->created_at;
            $timeInterval = $now->diffInHours($linkSentAt);

            if ($timeInterval > 2) {
                $link->delete();
            }
        }
        return 0;
    }
}
