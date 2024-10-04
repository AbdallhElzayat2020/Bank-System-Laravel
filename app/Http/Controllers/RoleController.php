<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

// use DB;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */


    function __construct()
    {
        $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);

        $this->middleware('permission:اضافة صلاحية', ['only' => ['create', 'store']]);

        $this->middleware('permission:تعديل صلاحية', ['only' => ['edit', 'update']]);

        $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);

        $this->middleware('permission:قائمة المستخدمين', ['only' => ['index']]);

        $this->middleware('permission:صلاحيات المستخدمين', ['only' => ['index']]);
    }



    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);

        return view('Dashboard.roles.index', compact('roles'));
    }

    public function create()
    {
        $permission = Permission::get();

        return view('Dashboard.roles.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ], [
            'name.required' => 'يرجى ادخال اسم الصلاحية',
            'permission.required' => 'يرجى اختيار الصلاحيات',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        // تحويل معرفات الأذونات إلى أسماء
        $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name');
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->with('success', 'تم اضافة الصلاحية بنجاح');
    }

    public function show($id)
    {
        $roles = Role::find($id);
        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->get();

        // dd($rolePermissions);
        return view('Dashboard.roles.show', compact('roles', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('Dashboard.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ], [
            'name.required' => 'يرجى ادخال اسم الصلاحية',
            'permission.required' => 'يرجى اختيار الصلاحيات',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        // تحويل معرفات الأذونات إلى أسماء
        $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name');
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->with('success', 'تم تعديل الصلاحية بنجاح');
    }


    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();

        return redirect()->route('roles.index')
            ->with('success', 'نم حذف الصلاحية بنجاح');
    }

}
