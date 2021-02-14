<template>
  <div class="mb-5">
    <div class="d-flex align-items-center">
      <input
        id="searchbar"
        name="searchbar"
        style="width: 50%"
        class="form-control-lg mr-sm-2"
        placeholder="Recherchez un médecin, un département, une ville"
        aria-label="Search"
        v-model="q"
        v-on:keypress.enter="fetchExperiences()"
      />

      <button
        v-on:click="fetchExperiences()"
        id="searchbar_btn"
        class="btn btn-lg btn-success"
        type="submit"
      >
        Search
      </button>
    </div>

    <div v-if="count == 1" class="alert alert-success" style="width: 50%">
      {{ count }} résultat
    </div>

    <div v-if="count > 1" class="alert alert-success" style="width: 50%">
      {{ count }} résultats
    </div>

    <div
      v-if="error_input_message"
      class="alert alert-danger"
      style="width: 50%"
    >
      {{ error_input_message }}
    </div>

    <div
      v-for="experience in experiences"
      v-bind:key="experience.id"
      class="card border-black mb-5 mt-5"
      style="width: 100%"
    >
      <div class="card-header bg-success text-white">
        Publié par {{ user.name }} le
        {{ experience.created_at }}
      </div>

      <div class="card-body text-black">
        <h5 class="card-title"></h5>

        <div class="alert alert-success" role="alert">
          <h4 class="alert-heading">
            Médecin : {{ experience.medecin_first_name }}
            {{ experience.medecin_last_name }}, {{ experience.speciality }}
          </h4>

          <p class="card-text p-0 m-0">
            Lieu : {{ experience.department_convert }}, {{ experience.city }}
          </p>

          <p class="card-text p-0 m-0">
            Date de consultation : {{ experience.date_rdv }}
          </p>

          <div class="card mt-3 mb-3">
            <div class="card-body">
              <p class="card-text">{{ experience.content }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      experiences: [],
      user: [],

      q: "",
      url: "/searchbar/",
      count: "",

      error_input_message: "",
    };
  },

  methods: {
    fetchExperiences() {

      this.error_input_message = "";
      this.count = "";
      this.experiences = "";

      if (this.q.length > 2) {

        axios
          .get(this.url + this.q)

          .then((res) => {
            console.log(res.data);

            this.experiences = res.data[0];
            this.user = res.data[1];
            this.count = this.experiences.length;
            this.error_input_message = "";

            //Si le retour de res.data[0] (expériences) est vide -> pas de résultat de recherche
            if (res.data[0].length == 0) {

              this.error_input_message =
                "Il n'y a pas de résultat pour votre recherche";
            }
          })
          .catch((error) => console.log(error));

      } else {
        console.log(this.q.length);
        console.log("Q else");
        this.error_input_message =
          "Votre recherche doit comporter au moins 3 caractères";
      }
    },
  },
};
</script>
