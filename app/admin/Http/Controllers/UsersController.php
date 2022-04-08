<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\DataTables\UsersDataTable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Kris\LaravelFormBuilder\FormBuilder;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = new User;
        if($request->get('q')) {
            $users = User::where('username', 'like', "%{$request->get('q')}%");
        }

        $data['users'] = $users->orderBy('created_at', 'DESC')->paginate(10);

        return view('panel::users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit($userId, FormBuilder $formBuilder)
    {

//dd( $user->getRoleNames()->first() );
        $user = User::find($userId);
        $form = $formBuilder->create('Modules\Panel\Forms\UserForm', [
            'method' => 'POST',
            'url' => url('/panel/userUpdate'),
            'model' => $user
        ]);
        return view('panel::users.create', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $record = $request->all();
        $user = User::find($record['id']);

        if($user->hasRole('admin') && $request->get('is_banned')) {
            return back();
        }

        /*if($user->is_admin && $user->id == 1 && !$request->get('is_admin', 0)) {
            alert()->danger('Cannot remove superadmin');
            return back();
        }*/
        unset($record['id']);

        $user->fill($record);

        if($request->get('is_banned')) {
            $user->ban();
        } else {
            $user->unban();
        }
		
		if($request->has('verified') != $user->verified) {
            $user->verified = $request->has('verified');
        }		
		
		if($request->input('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }
		
        $user->save();

        if($request->get('role') && !$user->hasRole($request->get('role'))) {
            $user->syncRoles([$request->get('role')]);
        }

        if($request->get('roles')) {
			$after = $request->input('roles');
			$before = $user->roles->pluck('id')->toArray();
			$same = ( count( $after ) == count( $before ) && !array_diff( $after, $before ) );
			if(!$same) {
				$user->syncRoles($request->get('roles'));
			}
        }

        return redirect()->route('panel.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($userId)
    {
	#dd($user);
        $user = User::find($userId);
        $user->delete();
        return redirect()->route('panel.users.index');
    }
}
