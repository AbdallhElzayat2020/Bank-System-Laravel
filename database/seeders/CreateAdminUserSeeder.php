<?php



namespace Database\Seeders;



use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

use App\Models\User;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;



class CreateAdminUserSeeder extends Seeder
{

    /**

     * Run the database seeds.

     */

    public function run(): void
    {

        $user = User::create([

            'name' => 'Admin',

            'email' => 'abdallhelzayat194@gmail.com',

            'password' => bcrypt('password'),

            'roles_name' => ['owner'],

            'Status' => 'مفعل',
        ]);

        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

    }

}
