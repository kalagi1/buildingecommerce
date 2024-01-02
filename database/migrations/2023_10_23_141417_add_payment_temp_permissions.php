<?php

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permission = PermissionGroup::create([
            "name" => "PaymentTemp",
            "is_active" => 1
        ]);

        Permission::create([
            "permission_group_id" => $permission->id,
            "key" => "PaymentTempList",
            "description" => "",
            "title" => "",
            "is_active" => 1
        ]);

        Permission::create([
            "permission_group_id" => $permission->id,
            "key" => "PaymentTempStatusChange",
            "description" => "",
            "title" => "",
            "is_active" => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        PermissionGroup::where('name',"PaymentTemp")->delete();
        Permission::where('key',"PaymentTempList")->delete();
        Permission::where('key',"PaymentTempStatusChange")->delete();
    }
};
