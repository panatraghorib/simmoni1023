<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserUpdateRequest;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Cabor;
use Inertia\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Inertia\Response;

use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });

        $numberPaginate = request('perPage') ?? 10;

        $users = QueryBuilder::for(User::class)
            ->defaultSort('name')
            ->allowedSorts(['name', 'email'])
            ->allowedFilters(['name', 'email', $globalSearch])
            ->paginate($numberPaginate)
            ->withQueryString();


        return Inertia::render('Users/Index', [
            'users' => $users,

        ])->table(
            function (InertiaTable $table) {
                $table
                    ->withGlobalSearch()
                    ->defaultSort('name')
                    ->column(key: 'name', searchable: true, sortable: true, canBeHidden: true, label: 'nama')
                    ->column(key: 'email', searchable: true, sortable: true)
                    ->column(key: 'email_verified_at',  label: 'Bergabung')
                    ->column(label: 'Actions');
            }
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $roles = Role::whereNot('id', 1)->orderBy('id')->get();
        return Inertia::render('Users/Create', [
            'roles' => $roles->map(fn ($role) => [
                'id' => $role->id,
                'label' => $role->name,
            ]),
            'cabor' => Cabor::all()->map(fn ($cabor) => [
                'id' => $cabor->id,
                'label' => $cabor->cabor_name,
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAddRequest $request)
    {

        DB::beginTransaction();

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'mobile' => $request->mobile,
            'date_of_birth' => $request->dateOfBirth,
            'gender' => $request->gender['label'],
            'organization_id' => !is_null($request->cabor) ? $request->cabor['id'] : 0,
            'avatar' => $request->file('avatar') ? $request->file('avatar')->store('users') : null,
            'created_by' => auth()->user(),
        ]);

        $roles = $request->roles['label'] ?? [];
        $user->assignRole($roles);

        activity('User')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $user])
            ->performedOn($user)
            ->event('created')
            ->log('User with Email' . $user->email . ' has been created');

        DB::commit();
        DB::rollBack();

        return redirect()->route('user.index')->with('message', [
            'type'   => 'success',
            'text'   => 'User berhasil ditambahkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        $roles = Role::whereNot('id', 1)->orderBy('id')->get(); // bisa di remove kalau diperlukan
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'date_of_birth' => $user->date_of_birth,
                'gender' => $user->gender,
                'organization_id' => $user->organization_id,
                // 'role' => $user->roles()->get(['id','name']),
                'roles' => $user->roles()->first()->id ?? null,
                'avatar' => $user->avatar ? URL::route('image', ['path' => $user->avatar, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
                'created_by' => $user->created_by,
            ],
            'roles' => $roles->map(fn ($role) => [
                'id' => $role->id,
                'label' => $role->name,
            ]),
            'cabor' => Cabor::all()->map(fn ($cabor) => [
                'id' => $cabor->id,
                'label' => $cabor->cabor_name
            ]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
    
        $user->update($request->only(
            'email',
            'username',
            'name',
            'mobile',
            // 'dateOfBirth',
            'cabor',
        ));

        if (request()->file('avatar')) {
            $user->update(['avatar' => $request->file('avatar')->store('users')]);
        }

        if ($request->get('password')) {
            $user->update(['password' => $request->get('password')]);
        }

        // return redirect()->back()->with('success', 'User updated.');
        return redirect()->route('user.index')->with('message', [
            'type' => 'success',
            'text' => 'User berhasil diperbarui!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
