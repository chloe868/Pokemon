<template>
  <div
    class="modal fade"
    id="connectionError"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="exampleModalLabel">
            {{ name && name.toUpperCase() }}
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            @click="hideModal()"
          >
            <span aria-hidden="true" class="text-primary">&times;</span>
          </button>
        </div>
        <div class="modal-body row">
          <div
            v-if="errorMessage !== null"
            class="alert alert-danger"
            role="alert"
          >
          {{errorMessage}}!
          </div>
          <div class="col-4" v-if="id !== null" style="text-align: center">
            <img
              :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/home/${id}.png`"
              width="150"
              height="150"
              :alt="`${name}`"
            />
          </div>
          <div class="col-8">
            <p><b>Type:</b> {{ type }}</p>
            <b>Abilities:</b>
            <div v-for="(itm, ndx) in abilities" :key="ndx">
              <ul>
                <li>{{ itm.charAt(0).toUpperCase() + itm.slice(1) }}</li>
              </ul>
            </div>
            <p><b>Height:</b> {{ height }}</p>
            <p><b>Weight:</b> {{ weight }}</p>
            <p><b>Description:</b> {{ details }}</p>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger"
            data-toggle="tooltip"
            data-placement="top"
            title="Add to hate"
            @click="addHateLikeFav('hate')"
          >
            <font-awesome-icon icon="fa-solid fa-thumbs-down" />
          </button>
          <button
            type="button"
            class="btn btn-primary"
            data-toggle="tooltip"
            data-placement="top"
            title="Add to like"
            @click="addHateLikeFav('like')"
          >
            <font-awesome-icon icon="fa-solid fa-thumbs-up" />
          </button>
          <button
            type="button"
            class="btn btn-warning"
            data-toggle="tooltip"
            data-placement="top"
            title="Add to favorite"
            @click="addHateLikeFav('fave')"
          >
            <font-awesome-icon icon="fa-solid fa-heart" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from "jquery";
import AUTH from "../services/auth";
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
export default {
  mounted() {},
  data() {
    return {
      name: null,
      details: null,
      id: null,
      height: null,
      weight: null,
      abilities: [],
      type: null,
      errorMessage: null,
    };
  },
  methods: {
    show(name) {
      this.name = name;
      this.errorMessage = null;
      this.fetchSpecificPokemon(name);
    },
    hideModal() {
      this.name = null;
      $("#connectionError").modal("hide");
    },
    addHateLikeFav(status) {
      let params = {
        mood: status,
        id: AUTH.userId,
        pokemon_id: this.name,
      };
      this.$axios
        .post(AUTH.url + "addPokemon", params, AUTH.config)
        .then((response) => {
          if (response.data && response.data.isValid === true) {
            this.hideModal();
            if (status === "like") {
              this.$router.push("/like");
            } else if (status === "hate") {
              this.$router.push("/hate");
            } else {
              this.$router.push("/favorite");
            }
          } else {
            this.errorMessage = response.data.errors;
          }
        })
        .catch((e) => {
          console.log(e);
        });
    },
    redirect(route) {
      this.$router.push(route);
    },
    fetchSpecificPokemon(name) {
      fetch(`https://pokeapi.co/api/v2/pokemon/${name}/`)
        .then((response) => response.json())
        .then((details) => {
          this.abilities = [];
          this.height = details.height;
          this.weight = details.weight;
          this.type =
            details.types[0].type.name.charAt(0).toUpperCase() +
            details.types[0].type.name.slice(1);
          details.abilities.forEach((ability) => {
            this.abilities = [...this.abilities, ability.ability.name];
          });
          this.fetchDetails(details);
        });
    },
    async fetchDetails(details) {
      fetch(`${details.species.url}`)
        .then((response) => response.json())
        .then((result) => {
          if (result.flavor_text_entries) {
            this.id = result.id;
            this.details = result.flavor_text_entries.filter(
              (el) => el.language.name === "en"
            )[0].flavor_text;
          }
        });
      await $("#connectionError").modal("show");
    },
  },
};
</script>
<style scoped>
.card-title {
  text-align: center;
}
</style>