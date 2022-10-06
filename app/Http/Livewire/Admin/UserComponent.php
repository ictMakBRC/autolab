<?php

namespace App\Http\Livewire\Admin;

use Exception;
use App\Models\User;
use App\Models\Study;
use Livewire\Component;
use App\Models\Facility;
use App\Models\Laboratory;
use App\Models\Designation;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use function Ramsey\Uuid\v1;

class UserComponent extends Component
{
    use WithFileUploads; 
    
    public $title;
    public $emp_no;
    public $surname;
    public $first_name;
    public $other_name;
    public $email;
    public $contact;
    public $laboratory_id;
    public $designation_id;
    public $avatar;
    public $signature;
    public $is_active;
    public $password;

    public $delete_id;
    public $avatarPath = '';
    public $signaturePath = '';

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'title' => 'required',
            'surname' => 'required',
            'first_name' => 'required',
            'email' => 'required|email:filter',
            'contact' => 'required',
            'laboratory_id' => 'required',
            'designation_id' => 'required',
            'is_active' => 'required',
            'avatar' => ['image', 'mimes:jpg,png', 'max:100','dimensions:max_width=160,max_height=160'],
            'signature' => ['image', 'mimes:jpg,png', 'max:100'],

        ]);
    }

    public function updatedTitle()
    {
        $this->generatePassword();
    }

    public function generatePassword($length = 2) {
        $numbers='0123456789';
        $symbols='!@#$%^&*()';
        $lowercase='abcdefghijklmnopqrstuvwxyz';
        $uppercase='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numberLength = strlen($numbers);
        $symbolLength = strlen($symbols);
        $uppercaseLength = strlen($uppercase);
        $lowercaseLength = strlen($lowercase);
        $randomNumber = '';
        $randomSymbol = '';
        $randomUppercase = '';
        $randomLowercase = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $numbers[rand(0, $numberLength - 1)];
            $randomSymbol .= $symbols[rand(0, $symbolLength - 1)];
            $randomUppercase .= $uppercase[rand(0, $uppercaseLength - 1)];
            $randomLowercase .= $lowercase[rand(0, $lowercaseLength - 1)];
        }
        $this->password=str_shuffle($randomNumber.$randomSymbol.$randomUppercase.$randomLowercase);
    }

    public function storeData()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:6'],
            'surname' => 'required',
            'first_name' => 'required',
            'email' => 'required|email:filter|unique:users',
            'contact' => 'required',
            'laboratory_id' => 'required',
            'designation_id' => 'required',
            'password' => ['required',
            Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()],
            'is_active' => ['required', 'integer', 'max:3'], 
        ]);

       

        if ( $this->avatar!=null && $this->signature!=null) {
            $this->validate([
                'avatar' => ['image', 'mimes:jpg,png', 'max:100'],
                'signature' => ['image', 'mimes:jpg,png', 'max:100'],
            ]);

            $avatarName = date('YmdHis').$this->surname.'.'.$this->avatar->extension();
            $signatureName = date('YmdHis').$this->surname.'.'.$this->signature->extension();
          
            $this->avatarPath = $this->avatar->storeAs('photos', $avatarName, 'public');
            $this->signaturePath = $this->signature->storeAs('signatures', $signatureName, 'public');
        } elseif ($this->avatar!=null) {

            $this->validate([
                'avatar' => ['image', 'mimes:jpg,png', 'max:100'],
            ]);
            $avatarName = date('YmdHis').$this->surname.'.'.$this->avatar->extension();
            $this->avatarPath = $this->avatar->storeAs('photos', $avatarName, 'public');
            $this->signaturePath = null;
        } elseif ($this->signature!=null) {
            $this->validate([
                'signature' => ['image', 'mimes:jpg,png', 'max:100'],
            ]);
            $signatureName = date('YmdHis').$this->surname.'.'.$this->signature->extension();
            $this->signaturePath = $this->signature->storeAs('signatures', $signatureName, 'public');
            $this->photoPath = null;
        } else {
            $this->avatarPath = null;
            $this->signaturePath = null;
        }

        $user = new User();
        $user->title = $this->title;
        $user->emp_no = $this->emp_no;
        $user->surname = $this->surname;
        $user->first_name = $this->first_name;
        $user->other_name = $this->other_name;
        $user->name = $this->first_name;
        $user->contact = $this->contact;
        $user->email = $this->email;
        $user->laboratory_id = $this->laboratory_id;
        $user->designation_id = $this->designation_id==""?NULL:$this->designation_id;
        $user->avatar = $this->avatarPath;
        $user->password = Hash::make($this->password);
        $user->signature = $this->signaturePath;

        $user->save();

        session()->flash('success', 'User created successfully.');
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editdata($id)
    {
        $user = User::where('id', $id)->first();
        $this->edit_id = $user->id;
        $this->title = $user->title;
        $this->surname = $user->surname;
        $this->first_name = $user->first_name;
        $this->other_name = $user->other_name;
        $this->name = $user->name;
        $this->contact = $user->contact;
        $this->email = $user->email;
        $this->laboratory_id = $user->laboratory_id;
        $this->designation_id = $user->designation_id;
        $this->is_active = $user->is_active;
        $this->avatarPath = $user->avatar;
        $this->signaturePath = $user->signature;

        $this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['password','title', 'emp_no', 'surname', 'first_name', 'other_name', 'email','contact','laboratory_id','designation_id','is_active','avatar','signature','avatarPath','signaturePath']);
    }

    public function updateData()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:6'],
            'surname' => 'required',
            'first_name' => 'required',
            'email' => 'required|email:filter',
            'contact' => 'required',
            'laboratory_id' => 'required',
            'designation_id' => 'required',
            'is_active' => ['required', 'integer', 'max:3'],
        ]);

        $user = User::find($this->edit_id);

        if ($this->avatar!=null && $this->signature!=null) {
            $this->validate([
                'avatar' => ['image', 'mimes:jpg,png', 'max:100'],
                'signature' => ['image', 'mimes:jpg,png', 'max:100'],
            ]);

            $avatarName = date('YmdHis').$this->surname.'.'.$this->avatar->extension();
            $signatureName = date('YmdHis').$this->surname.'.'.$this->signature->extension();

            $this->avatarPath = $this->avatar->storeAs('photos', $avatarName, 'public');
            $this->signaturePath = $this->signature->storeAs('signatures', $signatureName, 'public');

            if (file_exists(storage_path('app/public/').$user->avatar) || file_exists(storage_path('app/public/').$user->signature)) {
                @unlink(storage_path('app/public/').$user->avatar);
                @unlink(storage_path('app/public/').$user->signature);
            }
        } elseif ($this->avatar!=null) {
            $this->validate([
                'avatar' => ['image', 'mimes:jpg,png', 'max:100'],
            ]);

            $avatarName = date('YmdHis').$this->surname.'.'.$this->avatar->extension();
            $this->avatarPath = $this->avatar->storeAs('photos', $avatarName, 'public');

            if (file_exists(storage_path('app/public/').$user->avatar)) {
                @unlink(storage_path('app/public/').$user->avatar);
            }
        } elseif ($this->signature!=null) {
            $this->validate([
                'signature' => ['image', 'mimes:jpg,png', 'max:100'],
            ]);

            $signatureName = date('YmdHis').$this->surname.'.'.$this->signature->extension();
            $this->signaturePath = $this->signature->storeAs('signatures', $signatureName, 'public');

            if (file_exists(storage_path('app/public/').$user->signature)) {
                @unlink(storage_path('app/public/').$user->signature);
            }
        } else {
            $this->avatarPath = $user->avatar;
            $this->signaturePath = $user->signature;
        }

        $user->title = $this->title;
        $user->emp_no = $this->emp_no;
        $user->surname = $this->surname;
        $user->first_name = $this->first_name;
        $user->other_name = $this->other_name;
        $user->name = $this->first_name;
        $user->contact = $this->contact;
        $user->email = $this->email;
        $user->laboratory_id = $this->laboratory_id;
        $user->designation_id = $this->designation_id==""?NULL:$this->designation_id;
        $user->is_active = $this->is_active;
        $user->avatar = $this->avatarPath;
        $user->signature = $this->signaturePath;
        $user->update();

        session()->flash('success', 'User updated successfully.');
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;

        $this->dispatchBrowserEvent('delete-modal');
    }

    public function deleteData()
    {
        try {
            $user = User::where('id', $this->delete_id)->first();
            $user->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            session()->flash('success', 'User deleted successfully.');
        } catch(Exception $error) {
            session()->flash('erorr', 'User can not be deleted!.');
        }
    }

    public function cancel()
    {
        $this->delete_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function render()
    {
        $users = User::with('laboratory','designation')->latest()->get();
        $designations = Designation::where('is_active',1)->latest()->get();
        $laboratories = Laboratory::where('is_active',1)->latest()->get();

        return view('livewire.admin.user-component', compact('users', 'designations','laboratories'))->layout('layouts.app');
    }
}
