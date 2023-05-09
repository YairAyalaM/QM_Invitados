<div>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dropzone.css') }}">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/dropzone.js') }}"></script>
    <!-- iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .dz-remove::before {
            font-size: 14px;
            text-align: center;
            display: block;
            cursor: pointer;
            border: none;
            text-decoration: none !important;
            color: #696767;
            content: "\2665";
        }

        .dropzoneDragArea {
            background-color: #fbfdff;
            border: 2px dashed #c3c3c3;
            border-radius: 6px;
            padding: 40px;
            text-align: center;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .dropzoneDragArea .icon i {
            font-size: 3em;
            text-align: center;
            color: #696767;
            background-color: #dfdddd;
            height: 100px;
            width: 100px;
            margin-bottom: 20px;
            border-radius: 50%;
            padding: 25px 20px;
        }

        /* hover dropzone */
        @media(hover: hover) {
            .dropzoneDragArea:hover {
                background-color: #edf7fa;
                transition: 0.3s;
            }
        }

        .dropzone {
            box-shadow: 0px 2px 20px 0px #f2f2f2;
            border-radius: 10px;
        }

        .dropzoneDragArea h2,
        .note {
            color: #40405b;
        }
    </style>

    <x-danger-button wire:click="$set('open',true)">
        Crear nuevo usuario
    </x-danger-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <div class="text-center">
                Crear nuevo usuario
            </div>
        </x-slot>

        <x-slot name="content">
            <!-- form starts -->
            <form action="{{ route('form.data') }}" name="demoform" id="demoform" method="POST" class="dropzone" enctype="multipart/form-data">
                @if($profile_photo_path)
				@if($profile_photo_path == $profile_photo_path_old)
				<div class="mb-8 flex justify-center">
					<img class="object-center object-cover rounded-full h-36 w-36 mx-auto" src="{{$profile_photo_path}}" alt="photo">
				</div>
				@else
				<div class="mb-8 flex justify-center">
					<img class="object-center object-cover rounded-full h-36 w-36 mx-auto" src="{{$profile_photo_path->temporaryUrl()}}" alt="photo">
				</div>
				@endif
				@endif
                
                @csrf
                <div class="form-group">

                    <input type="hidden" class="userid" name="userid" id="userid" value="">

                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your name" class="form-control" required autocomplete="off" wire:model="name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" class="form-control" required autocomplete="off" wire:model="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="********" class="form-control" required autocomplete="off" wire:model="password">
                </div>

                <!-- <div class="flex flex-col lg:flex-row  gap-4 mb-4">
					<div class="mb-4">
						<label for="profile_photo_path" class="block text-gray-700 text-sm font-bold mb-2">Imagen:</label>
						<input type="file" wire:model="profile_photo_path" class="appearance-none block w-full bg-gray-200 text-gray-700 border  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-secondarycolor" id="profile_photo_path">
					</div>
				</div> -->

                <div class="form-group">
                    <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                        <div class="icon">
                            <!-- aqui va el iconoco -->
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <h2>Suelta tus archivos</h2>
                        <span class="note">No hay archivos seleccionados</span>
                    </div>
                    <div class="dropzone-previews"></div>
                </div>
                <!-- <div class="form-group">
					<button class="btn btn-md btn-primary">create</button>
				</div> -->

                <!-- form end -->
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button class="form-group" wire:click="cerrarModal()">
                Cancelar
            </x-jet-secondary-button>
            <x-danger-button wire:click="guardar()" type="submit" class="form-group">
                Guardar
            </x-danger-button>
        </x-slot>
        </form>
    </x-dialog-modal>
    <script>
        Dropzone.autoDiscover = false;
        // Dropzone.options.demoform = false;	
        let token = $('meta[name="csrf-token"]').attr('content');
        $(function() {
            var myDropzone = new Dropzone("div#dropzoneDragArea", {
                paramName: "file",
                url: "{{ route('form.img2') }}",
                previewsContainer: 'div.dropzone-previews',
                addRemoveLinks: true,
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 1,
                maxFilesize: 1,
                maxFiles: 100,
                acceptedFiles: ".jpeg, .jpg, .png, .gif, .pdf",
                params: {
                    _token: token
                },
                // The setting up of the dropzone
                init: function() {
                    var myDropzone = this;
                    //form submission code goes here
                    $("form[name='demoform']").submit(function(event) {
                        //Make sure that the form isn't actully being sent.
                        event.preventDefault();

                        URL = $("#demoform").attr('action');
                        formData = $('#demoform').serialize();
                        $.ajax({
                            type: 'POST',
                            url: URL,
                            data: formData,
                            success: function(result) {
                                if (result.status == "success") {
                                    // fetch the useid 
                                    var userid = result.user_id;
                                    $("#userid").val(userid); // inseting userid into hidden input field
                                    //process the queue
                                    myDropzone.processQueue();
                                } else {
                                    console.log("error");
                                }
                            }
                        });
                    });

                    //Gets triggered when we submit the image.
                    this.on('sending', function(file, xhr, formData) {
                        //fetch the user id from hidden input field and send that userid with our image
                        let userid = document.getElementById('userid').value;
                        formData.append('userid', userid);
                    });

                    this.on("success", function(file, response) {
                        //reset the form
                        $('#demoform')[0].reset();
                        //reset dropzone
                        $('.dropzone-previews').empty();
                    });

                    this.on("queuecomplete", function() {

                    });

                    // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                    // of the sending event because uploadMultiple is set to true.
                    this.on("sendingmultiple", function() {
                        // Gets triggered when the form is actually being sent.
                        // Hide the success button or the complete form.
                    });

                    this.on("successmultiple", function(files, response) {
                        // Gets triggered when the files have successfully been sent.
                        // Redirect user or notify of success.
                    });

                    this.on("errormultiple", function(files, response) {
                        // Gets triggered when there was an error sending the files.
                        // Maybe show form again, and notify user of error
                    });
                }
            });
        });
    </script>
</div>