<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Console\View\Components\Alert as ComponentsAlert;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Users extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;

    public $delete_id;
    protected $listeners = ['deleteConfirmed' => 'delete', 'render' => 'render'];
    public $name,$email,$password,$profile_photo_path,$profile_photo_path_old,$id_user,$position;
    public $user,$open_edit=false;
    public $modal = false;
    public $term;
    public function render()
    {
        $users = User::orWhere('name','like','%'.$this->term.'%')
        ->orWhere('email','like','%' .$this->term.'%')
        ->orderBy('position', 'asc')->paginate(10);
        return view('livewire.users.users',compact('users'));
    }
    public function crear()
    {
        $this->limpiarCampos();
        $this->abrirModal();
    }

    public function toggleStatus($userId)
{
    $user = User::findOrFail($userId);
    $user->status = !$user->status; // cambia el estado del usuario
    $user->save();

    $this->emit('userUpdated', $user->id, $user->status);
}


    public function abrirModal() {
        $this->modal = true;
    }

    public function cerrarModal() {
        $this->open_edit = false;
    }

    public function limpiarCampos(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->profile_photo_path = '';
        $this->profile_photo_path_old = '';
    }

    // public function editar(User $user)
    // {
    //     $this->user = $user->name;
    //     $this->open_edit = true;
    // }

    public function editar($id)
    {
        $user = User::findOrFail($id);
        $this->id_user = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->profile_photo_path = $user->profile_photo_path;
        $this->profile_photo_path_old = $user->profile_photo_path;
        $this->position = $id;
        // Storage::url($this->image->store('public/images'));
        // $this->abrirModal();
        $this->open_edit = true;
    }

    public function delete(){
        $user = User::where('id',$this->delete_id)->first();
        $user->delete();

        $this->dispatchBrowserEvent('FileDeleted');
    }

    public function deleteConfirmation($id){
        $this->delete_id = $id;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function guardar()
    {
        if($this->profile_photo_path == $this->profile_photo_path_old){
            $profile_photo_path = $this->profile_photo_path_old;
        }
        else{
            $profile_photo_path = Storage::url($this->profile_photo_path->store('public/images'));
        }

        $user=User::updateOrCreate(['id'=>$this->id_user],
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                $position = $this->id_user,
                // 'position' => $position,
                'profile_photo_path' =>  $profile_photo_path,
            ]);

            // funcion para igual la posicion con el id
            if(is_null($position)){
                User::where('id',$user->id)->update([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password,
                    'profile_photo_path' => $user->profile_photo_path,
                    'position' => $user->id,
                ]);
            }

        //  session()->flash('message',
        //     $this->id_asociacion ? '¡Actualización exitosa!' : '¡Alta Exitosa!');
        $this->alert('success', 'Alta exitosa!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
           ]);
         
         $this->cerrarModal();
         $this->limpiarCampos();
    }
}
