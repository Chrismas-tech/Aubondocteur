 <div class="jumbotron text-primary rounded bg_photo_3 mb-0 mt-1" id="jumbotron">

     <div class="bg-primary mt-3 p-4 rounded" style="width:60%; margin:auto;">

         <!-- RECHERCHEZ UN MEDECIN PAR SPECIALITE/VILLE-->
         <!-- RECHERCHEZ UN MEDECIN PAR SPECIALITE/VILLE-->
         <!-- RECHERCHEZ UN MEDECIN PAR SPECIALITE/VILLE-->
         <!-- RECHERCHEZ UN MEDECIN PAR SPECIALITE/VILLE-->
         <!-- RECHERCHEZ UN MEDECIN PAR SPECIALITE/VILLE-->

         <div class="mt-3 card p-4 " id="search_medecin_admin">
             <div class="text-center">
                 <h1 class="display-6 lobster text-primary mb-4 mt-3">Recherchez un médecin</h1>
             </div>
             <div>
                 <h2 class="lora text-primary mt-3">Par Spécialité/Ville</h2>
             </div>

             <div class="input-group-lg">
                 <form action="{{ route('find_medecin_admin_1') }}" method="get">
                     @csrf
                     <select type="text" name="select_accueil_admin" id="select_accueil_admin"
                         class="form-control @error('select_accueil_admin') is-invalid @enderror">
                         <option value="">Spécialité du médecin recherché</option>
                         @foreach ($specialities as $speciality)
                             <option value="{{ $speciality->speciality_name }}">{{ $speciality->speciality_name }}
                             </option>
                         @endforeach
                     </select>
             </div>


             <div class="input-group-lg mt-3">
                 <input type="text" class="form-control" name="city_input_admin" id="city_input_admin"
                     placeholder="Ville de recherche">
             </div>

             <div id="city_result_input_admin">
             </div>

             <div class="mt-3">
                 @error('select_accueil_admin')
                     <div class="alert alert-danger p_texte_3 text-danger">{{ $message }}</div>
                 @enderror

                 @error('city_input_admin')
                     <div class="alert alert-danger p_texte_3 text-danger">{{ $message }}</div>
                 @enderror
             </div>

             <div class="input-group-lg mt-3 text-center">
                 <button id="button_submit_medecin_1" type="submit" class="btn btn-success ">Recherchez</button>
             </div>
             </form>
         </div>


         <div class="text-center">
             <h1 class="display-6 lora text-white mb-4 mt-3">Ou</h1>
         </div>

         <!-- RECHERCHEZ UN MEDECIN PAR NOM OU PRENOM-->
         <!-- RECHERCHEZ UN MEDECIN PAR NOM OU PRENOM-->
         <!-- RECHERCHEZ UN MEDECIN PAR NOM OU PRENOM-->
         <!-- RECHERCHEZ UN MEDECIN PAR NOM OU PRENOM-->
         <!-- RECHERCHEZ UN MEDECIN PAR NOM OU PRENOM-->

         <div class="mt-3 card p-4 ">

             <div class="text-center">
                 <h1 class="display-6 lobster text-primary mb-4 mt-3">Recherchez un médecin</h1>
             </div>

             <div>
                 <h2 class="lora text-primary mt-3">Par Nom ou Prénom</h2>
             </div>

             <div class="input-group-lg">
                 <form action="{{ route('find_medecin_admin_2') }}" method="get">
                     @csrf
                     <div class="input-group-lg">
                         <input class="form-control" id="name_input_admin" type="text"
                             name="first_or_last_name_input_admin" placeholder="Prénom ou Nom du médecin">
                     </div>
             </div>

             <div class="mt-2" id="name_result_input_admin">
             </div>

             <div class="mt-3">
                 @error('first_or_last_name_input_admin')
                     <div class="alert alert-danger p_texte_3 text-danger">{{ $message }}</div>
                 @enderror
             </div>

             <div class="input-group-lg mt-5 text-center" id="div_button_submit">
                 <button disabled id="button_submit_medecin_2" type="submit"
                     class="btn btn-secondary ">Recherchez</button>
             </div>
             </form>
         </div>
     </div>
 </div>

 <script>
     $('document').ready(function() {

         var token = $('input[name ="_token"]').val();

         $('#city_input_admin').keyup(function() {
             $('#city_result_input_admin').empty()

             var query = $('#city_input_admin').val();

             if (!(query.empty) && query.length > 2) {

                 $.ajax({
                     url: "{{ route('search_city_admin_input') }}",
                     method: 'post',
                     data: {
                         _token: token,
                         query: query
                     },

                     success: function(res) {
                         $('#city_result_input_admin').html(res);
                     }
                 })
             }
         })

     })


     $(document).on("click", ".li_city_result_admin", function() {
         var li_val = $(this).html();
         $('#city_input_admin').val(li_val);
         $('#city_result_input_admin').empty();
         //   $('#city_input_admin').attr('disabled', true);
     });

     $(document).on("click", ".li_name_result_admin", function() {
         var li_html = $(this).html();
         var li_val = $(this).val();

         $('#name_input_admin').val(li_html);
         $('#name_result_input_admin').empty();
         //   $('#name_result_input_admin').attr('disabled', true);
     });

     $('document').ready(function() {
         $('#jumbotron').click(function() {
             $('#city_result_input_admin').empty();
             $('#name_result_input_admin').empty();
         })
     });


     $('document').ready(function() {

         var token = $('input[name ="_token"]').val();

         $('#name_input_admin').keyup(function() {
             $('#name_result_input_admin').empty()

             var query = $('#name_input_admin').val();

             if (!(query.empty) && query.length > 2) {

                 $.ajax({
                     url: "{{ route('search_name_admin_input') }}",
                     method: 'post',
                     data: {
                         _token: token,
                         query: query
                     },

                     success: function(res) {

                         $('#name_result_input_admin').html(res[0]);

                         if (res[1] == 1) {
                             $('#button_submit_medecin_2').removeAttr("disabled");
                             $('#button_submit_medecin_2').removeClass("btn-secondary");
                             $('#button_submit_medecin_2').addClass("btn-success");

                         } else if (res[1] > 1) {
                             $('#button_submit_medecin_2').removeAttr("disabled");
                             $('#button_submit_medecin_2').removeClass("btn-secondary");
                             $('#button_submit_medecin_2').addClass("btn-success");
                         } else {

                            //Si le button a déjà l'attribute disabled
                            if ($('#button_submit_medecin_2').attr('disabled')) {
                                
                            } else {
                                $('#button_submit_medecin_2').attr("disabled", true);
                                $('#button_submit_medecin_2').removeClass("btn-success");
                                $('#button_submit_medecin_2').addClass("btn-secondary");
                            }
                         }
                     }

                 })
             }
         })
     })

 </script>
