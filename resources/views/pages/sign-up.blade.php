<x-guest-layout title="Log in">
    <section class="container d-grid vh-100" style="place-items: center;">
        {{-- form --}}
        <form action="" class="w-100 border shadow-lg p-4" id="form-signup" style="max-width: 500px;">
            {{-- inputs --}}
            <div class="input-group mb-3">
                <label for="email" class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </label>
                <input type="text" name="name" id="name" class="form-control" placeholder="name" required autocomplete="name">
            </div>
            <div class="input-group mb-3">
                <label for="email" class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </label>
                <input type="email" name="email" id="email" class="form-control" placeholder="email@example.com" required autocomplete="email">
            </div>
            <div class="input-group mb-3">
                <label for="password" class="input-group-text">
                    <i class="bi bi-key"></i>
                </label>
                <input type="password" name="password" id="password" class="form-control" placeholder="********" minlength="8" required
                    autocomplete="current-password" minlength="8">
                <i class="input-group-text bi bi-eye" id="show-password" style="cursor: pointer;"></i>
            </div>

            {{-- btns --}}
            <div class="d-flex justify-content-end align-items-center gap-2">
                <a href="{{route('login')}}" class="btn btn-primary">Sign in</a>
                <button class="btn btn-primary" type="submit" id="btn-submit-signup">Sign up</button>
            </div>
        </form>
    </section>

    {{-- script --}}
    <script>
        window.addEventListener('DOMContentLoaded', ()=>{
            // show password
            show_password();
            // sign up
            signup();
        });

        // show password
        function show_password() {
            const password_toggler = $('#show-password');

            password_toggler.on('click', function () {
                const passwordField = $('#password');
                const fieldType = passwordField.attr('type');

                if (fieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('bi-eye').addClass('bi-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('bi-eye-slash').addClass('bi-eye');
                }
            });
        }

        // log in
        // function signup(){

        //     // submit form log in
        //     $('#form-sign-up').on('submit', async function(e){
        //         e.preventDefault();

        //         // disabled btn
        //         $('#btn-submit-sign-up').attr('disabled', true);

        //         try {
        //             // form data and fetch api
        //             const formData = new FormData(this);
        //             const response = await fetch(`${window.database_url}/users/admin.json?auth=${encodeURIComponent(window.token)}`);

        //             if(!response.ok){
        //                 throw new Error("");
        //             }else{
        //                 const response_json = await response.json(); // parse json response

        //                 // check if username was in the firebase
        //                 if(response_json.username == formData.get('email')){
        //                     if(response_json.password == formData.get('password')){

        //                         // make auth session
        //                         const _response = await fetch('{{route("generate-session")}}', {
        //                             method : 'POST',
        //                             headers : {
        //                                 'Content-Type' : 'application/json',
        //                                 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        //                             },
        //                             body: JSON.stringify({
        //                                 username : formData.get('email'),
        //                             })
        //                         });

        //                         // if not ok
        //                         if(!_response.ok){
        //                                 throw new Error("");
        //                         }else{ // if 200
        //                                 toastr.success("Successfully Register user", "Success");

        //                             setTimeout(() => {
        //                                 // disabled btn
        //                                     $('#btn-submit-sign-up').attr('disabled', true);
        //                                     window.location.href = './home';
        //                             }, 1500);
        //                         }

        //                     }else{
        //                         throw new Error("");
        //                     }
        //                 }else{ // if email was not in firebase then throw new error
        //                     throw new Error("");
        //                 }
        //             }
        //         } catch (error) {
        //             /**
        //              * catch errors and display toastr error
        //              * enable submit btn
        //             */
        //             console.error(error.message);
        //             toastr.error("Failed to register, Pls try again, If the problem persist, Contact Developer", "Error");
        //             $('#btn-submit-sign-up').attr('disabled', false);
        //         }
        //     });
        // }


        // mysql base login
        function signup(){
            $('#form-signup').on('submit', async function(e){
                e.preventDefault();

                // disabled btn
                $('#btn-submit-signup').attr('disabled', true);

                try {
                    // form data and fetch api
                    const formData = new FormData(this);
                    const response = await fetch('/sign-up-user', {
                        method : 'POST',
                        headers : {
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        },
                        body : formData
                    });

                    if(!response.ok){
                        throw new Error("");
                    }else{
                        toastr.success("Successfully Register User!", "Succes");

                        setTimeout(() => {
                            window.location.href = '/';
                        }, 1500);
                    }
                } catch (error) {
                    /**
                     * catch errors and display toastr error
                     * enable submit btn
                    */
                    console.error(error.message);
                    toastr.error("Failed to register", "Error");
                    $('#btn-submit-signup').attr('disabled', false);
                }
            });
        }
    </script>
</x-guest-layout>