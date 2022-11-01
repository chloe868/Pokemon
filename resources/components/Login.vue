<template>
  <div class="LoginContainer col-sm-12">
    <div class="row RowContainer">
      <div class="justify-content-center LoginCardContainer">
        <div class="card LoginCard">
          <div class="card-body LoginCardBody">
            <div class="d-flex justify-content-center pt-3 pb-4 mb-3">
              <b>Login</b>
            </div>
            <div>
              <p class="mb-2 pb-0 errorMessage" v-if="errorMessage != ''">
                {{ errorMessage }}
              </p>
              <input
                type="text"
                placeholder="Username"
                class="form-control roudedInput"
                v-model="username"
                :class="
                  !this.isValid && username == ''
                    ? 'mb-0 '
                    : ' LoginField'
                "
                :styles="{
                  border:
                    !this.isValid && username == ''
                      ? '1px solid red !important'
                      : 'none',
                }"
              />
              <p
                class="mb-0 pb-0 invalidEmail"
                v-if="!this.isValid && username == ''"
              >
                Required Field
              </p>
              <input
                type="password"
                placeholder="Password"
                class="form-control roudedInput"
                v-model="password"
                :class="
                  !this.isValid && password == '' ? 'mb-0 ' : ' LoginField'
                "
                :styles="{
                  border:
                    !this.isValid && password == ''
                      ? '1px solid red !important'
                      : 'none',
                }"
              />
              <p
                class="mb-0 pb-0 invalidEmail"
                v-if="!this.isValid && password == ''"
              >
                Required Field
              </p>
            </div>
            <div class="d-flex justify-content-between">
              <roundedBtn
                :onClick="login"
                :text="'Login'"
                :styles="{
                  backgroundColor: colors.secondary,
                  color: 'white',
                }"
              />
            </div>
            <div class="d-flex justify-content-center orSeparatorB">
              <p style="black">Don't have an account?</p>
            </div>
            <hr />
            <div
              class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end"
              style="margin-left: 4%"
            >
              <roundedBtn
                :onClick="register"
                :text="'Register'"
                :styles="{
                  backgroundColor: colors.primary,
                  color: 'white',
                }"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import roundedInput from "./generic/roundedInput.vue";
import roundedBtn from "./generic/roundedBtn.vue";
import COLORS from "../assets/style/colors";
import AUTH from '../services/auth'
// import ROUTER from '../../router/index'
export default {
  data() {
    return {
      username: "",
      password: "",
      errorMessage: "",
      isValid: true,
      colors: COLORS,
      // user: AUTH.user
    };
  },
  components: {
    roundedInput,
    roundedBtn,
  },
  mounted() {},
    methods: {
      login(event) {
      let parameter = {
        username: this.username,
        password: this.password,
      }
      this.$axios.post(AUTH.url + "login", parameter)
        .then(response => {
          console.log(response);
          localStorage.setItem('userId', response.data.user.id)
          AUTH.userId = response.data.user.id;
          AUTH.setToken(response.data.access_token)
          this.redirect('/dashboard')
        })
        .catch(error => {
          console.log('this is error')
          console.log(error)
        });
      },
      register() {
        this.$router.push('/register')
      },
      redirect(route) {
        this.$router.push(route).catch(() => {});
      },
    }
};
</script>

<style lang="scss" scoped>
@import "../assets/style/colors.scss";
.roudedInput {
  outline: none !important;
  box-shadow: none !important;
  height: 45px !important;
  border-radius: 40px !important;
  border: 1px solid $gray !important;
}
.errorMessage {
  margin-top: -14px;
  color: $danger;
  font-size: 10px;
  margin-bottom: 25px !important;
  text-align: center;
}
.invalidEmail {
  color: $danger;
  font-size: 10px;
  margin-left: 20px;
  margin-bottom: 25px !important;
}
.orSeparatorA {
  margin-top: 35px;
  margin-bottom: 15px;
}
.orSeparatorB {
  margin-top: 15px;
  margin-bottom: 20px;
}
.LoginField {
  margin-bottom: 20px;
}
.QouteText {
  font-size: 30px;
}
.SubQoute {
  text-align: left;
}
.QouteCard {
  width: 80% !important;
  margin-top: 5vh;
  margin-bottom: 5vh;
  text-align: left;
}
.LoginCard {
  width: 475px;
  background-color: "transparent";
  border-radius: 20px;
  box-shadow: 3px 3px 1px -2px rgba(1, 0, 154, 0.75);
  -webkit-box-shadow: 3px 3px 1px -2px rgba(1, 0, 154, 0.75);
  -moz-box-shadow: 3px 3px 1px -2px rgba(1, 0, 154, 0.75);
  max-height: 42.5rem;
}
.LoginCardBody {
  background-color: white;
  border-radius: 20px;
}
.LoginContainer {
  padding-top: 7%;
  min-height: 100vh;
  // background: url('../assets/img/test.png') !important;
  // background-size: cover !important;
}
.RowContainer {
  background-color: "transparent";
}
.QouteCardContainer {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  background: "none";
  margin-top: 5%;
}
.LoginCardContainer {
  background-color: "transparent";
  margin-top: 5%;
  margin-right: auto;
  margin-left: auto;
  padding-right: 5%;
  padding-left: 5%;
}

@media (max-width: 500px) {
  .LoginCard {
    width: 100%;
    max-height: 50.5rem;
  }
  .QouteText {
    font-size: 30px;
  }
}
@media (max-width: 1200px) {
  .QouteCardContainer {
    width: 90% !important;
  }
  .QouteText {
    font-size: 35px;
  }
}
@media (max-width: 1150px) {
  .QouteCardContainer {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
  }
  .LoginCardContainer {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
  }
}
@media (max-width: 950px) {
  .QouteCardContainer {
    -ms-flex: 0 0 40%;
    flex: 0 0 40%;
    max-width: 40%;
  }
  .LoginCardContainer {
    -ms-flex: 0 0 60%;
    flex: 0 0 60%;
    max-width: 60%;
  }roundedBtn
  .QouteText {
    font-size: 35px;
  }
}
@media (max-width: 768px) {
  .QouteCardContainer {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
  }
  .LoginCardContainer {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
  }
  .QouteText {
    font-size: 35px;
  }
  .QouteCard img {
    width: 100% !important;
  }
}
</style>
