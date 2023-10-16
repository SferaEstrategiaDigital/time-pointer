<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class JobsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:status {amount=5 : Amount of jobs to display} {--total : Display the total number of jobs instead of the last N jobs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the status of the queued jobs.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $totalJobs = DB::table('jobs')->count();

        // Se a opção --total for passada, mostre apenas o total de jobs
        if ($this->option('total')) {
            $this->info("Total jobs in queue: $totalJobs");
            return;
        }

        $amount = $this->argument('amount');

        $lastJobs = DB::table('jobs')
            ->orderBy('id', 'desc')
            ->take($amount)
            ->get();

        if ($lastJobs->isEmpty()) {
            $this->info("No jobs found in the queue.");
            return;
        }

        $this->info("Last $amount jobs in the queue:");
        foreach ($lastJobs as $job) {
            $this->line("ID: $job->id, Queue: $job->queue, Created at: $job->created_at");
        }
    }
}
