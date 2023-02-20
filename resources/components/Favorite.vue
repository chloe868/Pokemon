<template>
  <div class="container">
    <div class="column welcome-div">
      <img src="../assets/img/pokemon_logo.png" width="250" height="100" />
      <p style="margin-top: 5px">Here is the list of your favorite pokemon.</p>
    </div>

    <div class="divPokemon">
      <div class="container1 border-primary perPokemon">
        <div style="text-align: center">
          <img
            :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/home/${id}.png`"
            width="150"
            height="150"
            :alt="name"
          />
          <p>
            <b>{{ name }}</b>
          </p>
        </div>
        <div class="row" style="margin-left: 10%; margin-right: 10%">
          <div class="col-7">
            <p><b>Type:</b> {{ helper.displayWithCamelCase(type ? type : '') }}</p>
            <b>Abilities:</b>
            <div v-for="(itm, ndx) in abilities" :key="ndx">
              <ul>
                <li>{{ helper.displayWithCamelCase(itm) }}</li>
              </ul>
            </div>
            <p><b>Description:</b> {{ details }}</p>
          </div>
          <div class="col-5">
            <p><b>Color:</b> {{ helper.displayWithCamelCase(color ? color : '') }}</p>
            <p><b>Shape:</b> {{ helper.displayWithCamelCase(shape ? shape : '') }}</p>
            <p><b>Habitat:</b> {{ helper.displayWithCamelCase(habitat ? habitat : '') }}</p>
            <p><b>Generation:</b> {{ helper.displayWithCamelCase(generation ? generation : '') }}</p>
            <p><b>Growth rate:</b> {{ helper.displayWithCamelCase(growth_rate ? growth_rate : '') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Helper from '../services/helper';
import AUTH from "../services/auth";
export default {
  mounted() {
    this.fetchAllPokemon();
  },
  data() {
    return {
			helper: Helper,
      pokemons: [],
      pokemon_information: null,
      selected: null,
      id: null,
      name: null,
      limit: 1,
      count: 0,
      search: null,
      details: null,
      id: null,
      height: null,
      weight: null,
      abilities: [],
      type: null,
      habitat: null,
      color: null,
      generation: null,
      growth_rate: null,
      shape: null,
    };
  },
	components: {
		Helper
	},
  computed: {
    fetch_pokemons() {
      return this.pokemons.filter((item) => {
        return item.name;
      });
    },
  },
  methods: {
    fetchAllPokemon() {
      let params = {
        id: AUTH.userId,
        mood: 'favorite'
      };
      this.$axios
        .post(AUTH.url + "retrieveLikeHateFave", params, AUTH.config)
        .then((response) => {
          if(response.data.pokemon.length > 0){
            this.fetchPokemon(response.data.pokemon)
          }
        })
        .catch((e) => {
          if(e.response && e.response.status === 401){
            AUTH.deauthenticate()
          }
        });
    },
    get_id(pokemon) {
      return Number(pokemon.url.split("/")[6]);
    },
    get_name(pokemon) {
      return this.helper.displayWithCamelCase(pokemon.name)
    },
    fetchPokemon(name) {
      fetch(`https://pokeapi.co/api/v2/pokemon/${name}/`)
        .then((response) => response.json())
        .then((details) => {
          this.abilities = []
          this.name = details.name.toUpperCase(),
          this.height = details.height
          this.weight = details.weight
          this.type = details.types[0].type.name
          details.abilities.forEach((ability) => {
            this.abilities = [...this.abilities, ability.ability.name]
          })
          this.fetchDetails(details)
        });
    },
    async fetchDetails(details) {
      fetch(`${details.species.url}`)
        .then((response) => response.json())
        .then((result) => {
          this.habitat = result.habitat.name;
          this.color = result.color.name;
          this.generation = result.generation.name;
          this.growth_rate = result.growth_rate.name;
          this.shape = result.shape.name;
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
  width: 98%;
  margin: 1%;
  padding: 2%;
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
