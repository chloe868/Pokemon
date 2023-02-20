<template>
  <div class="container">
    <div class="column welcome-div">
      <img src="../../assets/img/pokemon_logo.png" width="250" height="100" />
      <p style="margin-top: 5px">{{ title }}</p>
    </div>
    <div class="divPokemon">
      <div
        class="container1 border-primary perPokemon"
      >
        <div style="text-align: center">
          <img
            :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/home/${data.id}.png`"
            width="150"
            height="150"
            :alt="item"
          />
          <p>
            <b>{{ data.name.toUpperCase() }}</b>
          </p>
        </div>

        <div>
          <p><b>Type:</b> {{ helper.displayWithCamelCase(data.types[0].type.name) }}</p>
          <p><b>Height:</b> {{ data.heigth }}</p>
          <p><b>Weight:</b> {{ data.weight }}</p>
          <b>Abilities:</b>
          <div v-for="(itm, ndx) in abilities" :key="ndx">
            <ul>
              <li>{{ helper.displayWithCamelCase(itm) }}</li>
            </ul>
          </div>
          <p><b>Description:</b> {{ data.details }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Helper from "../../services/helper";
export default {
  props: ["data", "title"],
  mounted() {
    this.renderData(this.data)
  },
  data() {
    return {
      helper: Helper,
      abilities: []
    };
  },
  components: {
    Helper
  },
  methods: {
    renderData(data){
      data.abilities.forEach((ability) => {
        this.abilities = [...this.abilities, ability.ability.name];
      });
    }
  }
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
