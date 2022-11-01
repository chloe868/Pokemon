<template>
  <div class="container">
    <div class="column welcome-div">
      <img src="../assets/img/pokemon_logo.png" width="250" height="100" />
      <p style="margin-top: 5px">Here are the lists of pokemons.</p>
    </div>

    <div class="divPokemon">
      <div
        class="card border-primary perPokemon"
        style="max-width: 100%; text-align: center"
        v-for="(item, ndx) in fetch_pokemons"
        :key="ndx"
        @click="showModal(item.name)"
      >
        <div style="text-align: center">
          <img
            :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/home/${get_id(
              item
            )}.png`"
            width="100"
            height="100"
            :alt="item"
          />
        </div>
        <div class="card-body">
          <h5 class="card-title">{{ get_name(item) }}</h5>
        </div>
      </div>

      <button
        type="button"
        class="btn btn-secondary"
        v-if="offset > 0"
        @click="fetchAllPokemon(false)"
      >
        Previous
      </button>
      <button
        type="button"
        class="btn btn-primary"
        v-if="offset < count + 12"
        @click="fetchAllPokemon(true)"
      >
        Next
      </button>
    </div>
    <PokemonInformation ref="add" @onConfirm="remove($event)" />
  </div>
</template>
<script>
import PokemonInformation from "./PokemonInformation.vue";
export default {
  mounted() {
    this.fetchAllPokemon();
  },
  data() {
    return {
      pokemons: [],
      pokemon_information: null,
      selected: null,
      offset: 0,
      limit: 12,
      count: 0,
      id: null,
      search: null
    };
  },
  computed: {
    fetch_pokemons() {
      return this.pokemons.filter((item) => {
        return item.name;
      });
    },
  },
  methods: {
    fetchAllPokemon(flag) {
      if (flag != null) {
        if (flag) {
          this.offset += this.limit;
        } else {
          this.offset -= this.limit;
        }
      }
      fetch(
        `https://pokeapi.co/api/v2/pokemon?limit=${this.limit}&offset=${this.offset}`
      )
        .then((response) => response.json())
        .then((allpokemon) => {
          this.pokemons = allpokemon.results;
          this.count = allpokemon.count;
        });
    },
    get_id(pokemon) {
      return Number(pokemon.url.split("/")[6]);
    },
    get_name(pokemon) {
      return pokemon.name.charAt(0).toUpperCase() + pokemon.name.slice(1);
    },
    showModal(name) {
      this.$refs.add.show(name);
    },
  },
  components: {
    PokemonInformation,
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
  width: 23%;
  margin: 1%;
  text-align: center;
  height: 150px;
}

.card {
  border-radius: 25px;
  background: #fff;
  box-shadow: 0 6px 10px rgba(0, 0, 0, 0.08), 0 0 6px rgba(0, 0, 0, 0.05);
  transition: 0.3s transform cubic-bezier(0.155, 1.105, 0.295, 1.12),
    0.3s box-shadow,
    0.3s -webkit-transform cubic-bezier(0.155, 1.105, 0.295, 1.12);
  cursor: pointer;
}

.card:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.06);
}

.btn-secondary {
  margin-right: 1%;
}
</style>
