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
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>  Invitado
    </x-danger-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <div class="text-center">
                Agregar Invitado
            </div>
        </x-slot>

        <x-slot name="content">
            <!-- form starts -->
            
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

                <div style="display: none" wire:loading wire:target="profile_photo_path" class="flex bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700" role="alert">
                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <span class="font-medium">Cargando imagen!</span> Espere un momento.
                </div>
            </div>

            <div class="bg-white p7 rounded w-full mx-auto">
					<div x-data="dataFileDnD()" class="relative flex flex-col text-gray-400 border border-gray-200 rounded">
						<div x-ref="dnd" class="relative flex flex-col text-gray-400 border border-gray-200 border-dashed rounded cursor-pointer">
							<input id="profile_photo_path" wire:model="profile_photo_path" type="file" class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer" @change="addFiles($event)" @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');" @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');" @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');" title="" />

							<div class="flex flex-col items-center justify-center py-10 text-center">
								<svg class="w-6 h-6 mr-1 text-current-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
								</svg>
								<p class="m-0">Drag your files here or click in this area.</p>
							</div>
						</div>

						<template x-if="files.length > 0">
							<div class="grid grid-cols-2 gap-4 mt-4 md:grid-cols-6" @drop.prevent="drop($event)" @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
								<template x-for="(_, index) in Array.from({ length: files.length })">
									<div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none" style="padding-top: 100%;" @dragstart="dragstart($event)" @dragend="fileDragging = null" :class="{'border-blue-600': fileDragging == index}" draggable="true" :data-index="index">
										<button class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none" type="button" @click="remove(index)">
											<svg class="w-4 h-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
											</svg>
										</button>
										<template x-if="files[index].type.includes('audio/')">
											<svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
											</svg>
										</template>
										<template x-if="files[index].type.includes('application/') || files[index].type === ''">
											<svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
											</svg>
										</template>
										<template x-if="files[index].type.includes('image/')">
											<img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview" x-bind:src="loadFile(files[index])" />
										</template>
										<template x-if="files[index].type.includes('video/')">
											<video class="absolute inset-0 object-cover w-full h-full border-4 border-white pointer-events-none preview">
												<fileDragging x-bind:src="loadFile(files[index])" type="video/mp4">
											</video>
										</template>

										<div class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-white bg-opacity-50">
											<span class="w-full font-bold text-gray-900 truncate" x-text="files[index].name">Loading</span>
											<span class="text-xs text-gray-900" x-text="humanFileSize(files[index].size)">...</span>
										</div>

										<div class="absolute inset-0 z-40 transition-colors duration-300" @dragenter="dragenter($event)" @dragleave="fileDropping = null" :class="{'bg-blue-200 bg-opacity-80': fileDropping == index && fileDragging != index}">
										</div>
									</div>
								</template>
							</div>
						</template>
					</div>
				</div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button class="form-group" wire:click="cerrarModal()">
                Cancelar
                </x-jet-secondary-button>
                <x-danger-button wire:click="guardar()" type="submit" class="form-group">
                    Guardar
                </x-danger-button>
        </x-slot>
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