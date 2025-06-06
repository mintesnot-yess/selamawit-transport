<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $modules = [
            "Order",
            "Payment Collection",
            "Commission",
            "Expense",
            "Vehicles",
            "Drivers",
            "Location",
            "Load Type",
            "Bank",
            "Staff User",
            "Role",
            "Give Permission",
            "Report",
            "Expense Type",
            "Client"
        ];

        $actions = ['view', 'create', 'edit', 'delete']; // common CRUD actions

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissionName = strtolower($action . '-' . str_replace(' ', '-', $module));

                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'display_name' => ucfirst($action) . ' ' . $module,
                    'description' => ucfirst($action) . ' ' . $module,
                ]);
            }
        }
    }
}
