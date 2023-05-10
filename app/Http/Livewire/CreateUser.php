<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateUser extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $open = false;
    public $term;
    public $name,$email,$password,$profile_photo_path,$profile_photo_path_old,$id_user,$position;
    public function render()
    {
        return view('livewire.create-user');
    }
 
    public function cerrarModal() {
        $this->open = false;
        $this->limpiarCampos();
    }

    public function limpiarCampos(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->profile_photo_path = '';
        $this->profile_photo_path_old = '';
    }

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
        $this->abrirModal();
    }

    public function storeData(Request $request)
	{
		try {
			$user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->position = $user->id;
            $user->save();
            $user_id = $user->id; // this give us the last inserted record id

             // funcion para igual la posicion con el id
             if(is_null($user->position)){
                User::where('id',$user->id)->update([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password,
                    'profile_photo_path' => $user->profile_photo_path,
                    'position' => $user->id,
                ]);
            }
		}
		catch (\Exception $e) {
			return response()->json(['status'=>'exception', 'msg'=>$e->getMessage()]);
		}
		return response()->json(['status'=>"success", 'user_id'=>$user_id]);
	}



	// We are submitting are image along with userid and with the help of user id we are updateing our record
	public function storeImage(Request $request)
	{
		if($request->file('file')){

            // $img = $request->file('file');
            $img = $request->file('file')->store('/public/images');

            //here we are geeting userid alogn with an image
            $userid = $request->userid;
            $original_name = $img;
            $imageName = Storage::url($original_name);
            // $imageName = strtotime(now()).rand(11111,99999).'.'.$img->getClientOriginalExtension();
            $user_image = new User();
            // $original_name = $img->getClientOriginalName();
            //profile_photo_path es el campo en la base de datos donde se va a guardar la ruta
            $user_image->profile_photo_path = $imageName;
            ///uploads/images/ son las rutas donde se van a almacenar las imagenes
            if(!is_dir(public_path() . '/public/images')){
                mkdir(public_path() . '/public/images', 0777, true);
            }

        $request->file('file')->move(public_path() . '/public/images', $imageName);

        // we are updating our image column with the help of user id
        //profile_photo_path es el campo en la base de datos donde se va a guardar la ruta
        $user_image->where('id', $userid)->update(['profile_photo_path'=>$imageName]);

        return response()->json(['status'=>"success",'imgdata'=>$original_name,'userid'=>$userid]);
        }
	}

    public function storeMultipleImage(Request $request){
        try {
            $imageArr = [];
            foreach ($request->file('file') as $file) {
                // $img = $request->file('file')->store('/public/images');
                $img = $file->store('/public/images');
                $userid = $request->userid;
                $original_name = $img;
                $imageName = Storage::url($original_name);
                // $imageName = strtotime(now()).rand(11111,99999).'.'.$img->getClientOriginalExtension();
                $user_image = new User();
                // $original_name = $img->getClientOriginalName();
                //profile_photo_path es el campo en la base de datos donde se va a guardar la ruta
                $user_image->profile_photo_path = $imageName;
                ///uploads/images/ son las rutas donde se van a almacenar las imagenes
                if(!is_dir(public_path() . '/public/images')){
                    mkdir(public_path() . '/public/images', 0777, true);
                }

                $file->move(public_path() . '/public/images', $imageName);
                array_push($imageArr, $imageName);

            }
            $imageArrToStr = implode(",", $imageArr);
            $result = $user_image->where('id', $userid)->update(['profile_photo_path'=>$imageArrToStr]);
            if ($result) {
                return response()->json(['status'=>"success",'msg'=>'Image Uploaded Successfully','userid'=>$userid]);
            }
            else{
                return response()->json(['status'=>"success",'msg'=>'Image Uploaded Faild','userid'=>$userid]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
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