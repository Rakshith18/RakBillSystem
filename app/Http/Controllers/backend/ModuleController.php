<?php

namespace App\Http\Controllers\backend;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\RoleModule;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->checkpermission('module-list');
        $module = Module::orderBy('name', 'asc')->paginate(10);
        return view('backend.module.list', compact('module'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->checkpermission('module-create');
        $role = Role::all();
        return view('backend.module.create', compact('role'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'module_key' => 'required|unique:modules',
            'module_url' => 'required',
            'module_rank' => 'required',
        ]);
        $module = Module::create([
            'name' => $request->name,
            'module_key' => $request->module_key,
            'module_url' => $request->module_url,
            'view_sidebar' => $request->view_sidebar,
            'module_icon' => $request->module_icon,
            'module_rank' => $request->module_rank,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        if ($module) {
            foreach ($request->roles as $role) {
                $rolemodule = new RoleModule();
                $rolemodule->module_id = $module->id;
                $rolemodule->role_id = $role;
                $rolemodule->save();
            }
            return redirect()->route('module.list')->with('success_message', 'You are Successfully Created');
        } else {
            return redirect()->route('module.create')->with('error_message', 'You cannot Create Rignt Now');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $this->checkpermission('module-edit');
        $role = Role::all();
        $module = Module::find($id);
        return view('backend.module.edit', compact('module','role'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request, [
            'name' => 'required',
            'module_url' => 'required',
            'module_rank' => 'required',
        ]);
        $pc = Module::find($id);
        $pc->name = $request->name;
        $pc->module_url = $request->module_url;
        $pc->view_sidebar = $request->view_sidebar;
        $pc->module_icon = $request->module_icon;
        $pc->module_rank = $request->module_rank;
        $pc->updated_at = date('Y-m-d H:i:s');
        $message = $pc->update();
        if ($message) {
            return redirect()->route('module.list')->with('success_message', 'Successfully Updated');
        } else {
            return redirect()->route('module.update')->with('error_message', 'Failed to Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
