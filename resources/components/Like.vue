<template>
  <div class="container">
    <div class="column welcome-div">
      <img src="../assets/img/pokemon_logo.png" width="250" height="100" />
      <p style="margin-top: 5px">Here are the lists of your liked pokemons.</p>
    </div>

    <div class="divPokemon">
      <div
        class="container1 border-primary perPokemon"
        v-for="(item, ndx) in pokemons"
        :key="ndx"
      >
        <div style="text-align: center">
          <img
            :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/home/${item.id}.png`"
            width="150"
            height="150"
            :alt="item.name"
          />
          <p>
            <b>{{ item.name }}</b>
          </p>
        </div>

        <div>
          <p><b>Type:</b> {{ item.type }}</p>
          <b>Abilities:</b>
          <div v-for="(itm, ndx) in item.abilities" :key="ndx">
            <ul>
              <li>{{ helper.displayWithCamelCase(itm) }}</li>
            </ul>
          </div>
          <!-- <p><b>Description:</b> {{ item.details }}</p> -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Helper from "../services/helper";
import AUTH from "../services/auth";
export default {
  mounted() {
    this.fetchLike();
  },
  data() {
    return {
      storePokemon: [],
      pokemons: [],
      helper: Helper,
      test: [],
      pokemon_information: null,
      selected: null,
      id: null,
      name: null,
      search: null,
      details: null,
      id: null,
      height: null,
      weight: null,
      abilities: [],
      type: null,
    };
  },
  components: {
    Helper,
  },
  methods: {
    fetchLike() {
      let params = {
        id: AUTH.userId,
        mood: 'like'
      };
      this.$axios
        .post(AUTH.url + "retrieveLikeHateFave", params, AUTH.config)
        .then((response) => {
          if(response.data.pokemon.length > 0){
            response.data.pokemon.forEach(el => {
              this.fetchPokemon(el)
            });
          }
        })
        .catch((e) => {
          if(e.response && e.response.status === 401){
            AUTH.deauthenticate()
          }
        });
    },
    fetchPokemon(name) {
      fetch(`https://pokeapi.co/api/v2/pokemon/${name}/`)
        .then((response) => response.json())
        .then((details) => {
          let abilities = []
            details.abilities.forEach((ability) => {
            abilities = [...abilities, ability.ability.name];
          });
          this.pokemons.push({
            id: details.id,
            name: details.name.toUpperCase(),
            height: details.height,
            weight: details.weight,
            type: this.helper.displayWithCamelCase(details.types[0].type.name),
            abilities: abilities
          })
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
    },
  },
};
</script>
<style scoped lang="scss">
.divPokemon {
  display: flex;
  flex-wrap: wrap;
}

.welcome-div {
  text-align: center;
  margin-top: 5%;
}

.perPokemon {
  width: 31%;
  margin: 1%;
  padding: 3%;
  height: 10%;
}

.container1 {
  border-radius: 25px;
  background: #fff;
  box-shadow: 0 6px 10px rgba(0, 0, 0, 0.08), 0 0 6px rgba(0, 0, 0, 0.05);
  transition: 0.3s transform cubic-bezier(0.155, 1.105, 0.295, 1.12),
    0.3s box-shadow,
    0.3s -webkit-transform cubic-bezier(0.155, 1.105, 0.295, 1.12);
  cursor: pointer;
}

.container1:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.06);
}

.btn-secondary {
  margin-right: 1%;
}
</style>
