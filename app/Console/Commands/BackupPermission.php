<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = \App\Models\Permission::get()->toTree();
        file_put_contents(database_path('seeders/data/Permissions.json'), $this->mapTree($data));
    }

    public function mapTree($tree)
    {
        return $tree->map(function ($item) {
            $mappedItem = [
                'name' => $item->name,
                'slug' => $item->slug,
            ];

            if ($item->children) {
                $mappedItem['children'] = $this->mapTree($item->children);
            }

            return $mappedItem;
        });
    }
}
