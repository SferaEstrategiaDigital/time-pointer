<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = file_get_contents(database_path('seeders/data/Permissions.json'));
        foreach (json_decode($data) as $info) {
            $this->createNode($info);
        }
    }

    public function createNode($info, $parentId = null)
    {
        $node = Permission::create([
            'slug' => $info->slug,
            'name' => $info->name,
            'parent_id' => $parentId,
        ]);

        if (!empty($info->children)) {
            foreach ($info->children as $child) {
                $this->createNode($child, $node->id);
            }
        }
    }
}
