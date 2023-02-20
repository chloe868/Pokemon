<template>
  <div class="LoginContainer col-sm-12">
    <div class="RowContainer">
      <div class="justify-content-center LoginCardContainer mb-5">
        <div class="card RegisterCard">
          <div class="card-body">
            <div class="d-flex justify-content-center pt-3 pb-4 mb-3">
              <b>Register</b>
            </div>
            <p class="mb-2 pb-0 errorMessage" v-if="errorMessage != null">
              {{ errorMessage }}
            </p>
            <div>
              <input
                type="text"
                placeholder="First name"
                class="form-control roudedInput"
                v-model="firstName"
                :class="
                    !this.isValid && firstName == ''
                    ? 'mb-0 '
                    : ' registrationField'
                "
                :styles="{
                  border:
                    !this.isValid && firstName == ''
                      ? '1px solid red !important'
                      : 'none',
                }"
              />
              <p
                class="mb-0 pb-0 requiredFieldError"
                v-if="!this.isValid && firstName == ''"
              >
                Required Field
              </p>
              <input
                type="text"
                placeholder="Last name"
                class="form-control roudedInput"
                v-model="lastName"
                :class="
                    !this.isValid && lastName == ''
                    ? 'mb-0 '
                    : ' registrationField'
                "
                :styles="{
                  border:
                    !this.isValid && lastName == ''
                      ? '1px solid red !important'
                      : 'none',
                }"
              />
              <p
                class="mb-0 pb-0 requiredFieldError"
                v-if="!this.isValid && lastName == ''"
              >
                Required Field
              </p>
              <input
                type="text"
                placeholder="Username"
                class="form-control roudedInput"
                v-model="username"
                :class="
                  !this.isValid && username == ''
                    ? 'mb-0 '
                    : ' registrationField'
                "
                :styles="{
                  border:
                    !this.isValid && username == ''
                      ? '1px solid red !important'
                      : 'none',
                }"
              />
              <p
                class="mb-0 pb-0 requiredFieldError"
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
                  !this.isValid &&
                  (password == '' ||
                    password != cpassword ||
                    passwordRequirements != '')
                    ? 'mb-0 '
                    : ' registrationField'
                "
                :styles="{
                  border:
                    !this.isValid &&
                    (password == '' ||
                      password != cpassword ||
                      passwordRequirements != '')
                      ? '1px solid red !important'
                      : 'none',
                }"
              />
              <p
                class="mb-0 pb-0 requiredFieldError"
                v-if="
                  !this.isValid &&
                  (password == '' ||
                    password != cpassword ||
                    passwordRequirements != '')
                "
              >
                {{
                  password != cpassword
                    ? passwordRequirements != ""
                      ? passwordRequirements
                      : "Password Did Not Match"
                    : passwordRequirements != ""
                    ? passwordRequirements
                    : "Required Field"
                }}
              </p>
              <!-- <p class="mt-2"><b>Confirm Password</b></p> -->
              <input
                type="password"
                placeholder="Confirm Password"
                class="form-control roudedInput"
                v-model="cpassword"
                :class="
                  !this.isValid &&
                  (password == '' ||
                    password != cpassword ||
                    passwordRequirements != '')
                    ? 'mb-0 '
                    : ' registrationField'
                "
                :styles="{
                  border:
                    !this.isValid &&
                    (password == '' ||
                      password != cpassword ||
                      passwordRequirements != '')
                      ? '1px solid red !important'
                      : 'none',
                }"
              />
              <p
                class="mb-0 pb-0 requiredFieldError"
                v-if="
                  !this.isValid &&
                  (password == '' ||
                    password != cpassword ||
                    passwordRequirements != '')
                "
              >
                {{
                  password != cpassword
                    ? passwordRequirements != ""
                      ? passwordRequirements
                      : "Password Did Not Match"
                    : passwordRequirements != ""
                    ? passwordRequirements
                    : "Required Field"
                }}
              </p>
            </div>
            <div class="d-flex justify-content-between">
              <roundedBtn
                :onClick="register"
                :text="'Register'"
                :styles="{
                  backgroundColor: colors.secondary,
                  color: 'white',
                }"
              />
            </div>
            <div class="d-flex justify-content-center orSeparatorA">
              <p>Have an account?</p>
            </div>
            <hr />
            <div
              class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end"
            >
              <roundedBtn
                :onClick="login"
                :text="'Login'"
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
import dialogueBtn from "./generic/dialogueBtn.vue";
import roundedInput from "./generic/roundedInput.vue";
import roundedBtn from "./generic/roundedBtn.vue";
import COLORS from "../assets/style/colors.js";
import AUTH from "../services/auth";
import Helper from "../services/helper";
export default {
  data() {
    return {
      username: "",
      password: "",
      firstName: "",
      lastName: "",
      cpassword: "",
      isValid: true,
      passwordRequirements: "",
      colors: COLORS,
      helper: Helper,
      errorMessage: null,
    };
  },
  components: {
    dialogueBtn,
    roundedInput,
    roundedBtn,
    COLORS,
    Helper,
  },
  methods: {
    login() {
      this.$router.push("/login");
    },
    register(event) {
      if (this.validate()) {
        this.isValid = true;
        let parameter = {
          firstname: this.firstName,
          lastname: this.lastName,
          username: this.username,
          password: this.password,
          password_confirmation: this.cpassword,
        };
        this.$axios
          .post(AUTH.url + "register", parameter)
          .then((response) => {
            this.login()
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    validate() {
      this.errorMessage = null;
      let firstName = this.firstName;
      let lastName = this.lastName;
      let username = this.username;
      let password = this.password;
      let cpassword = this.cpassword;
      if (
        firstName === "" ||
        lastName === "" ||
        username === "" ||
        password === "" ||
        cpassword === ""
      ) {
        this.isValid = false;
        return false;
      } else if (username.includes(" ")) {
        this.isValid = false;
        this.errorMessage = "Username should not contain spaces.";
        return false;
      } else if (!this.helper.validatePassword(password)) {
        this.isValid = false;
        this.passwordRequirements =
          "Password should be minimum of 6 and should contain at least one digit, lower case, upper case and special character.";
        return false;
      }
      this.passwordRequirements = "";
      return true;
    },
  },
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
.requiredFieldError {
  color: $danger;
  font-size: 10px;
  margin-left: 20px;
  margin-bottom: 25px !important;
}
.errorMessage {
  margin-top: -14px;
  color: $danger;
  margin-bottom: 25px !important;
  text-align: center;
}
.orSeparatorA {
  margin-top: 20px;
  margin-bottom: 15px;
}
.orSeparatorB {
  margin-top: 15px;
  margin-bottom: 35px;
}
.registrationField {
  margin-bottom: 20px;
}
.RegisterCard {
  width: 475px;
  background-color: white;
  border-radius: 20px;
  box-shadow: 3px 3px 1px -2px rgba(1, 0, 154, 0.75);
  -webkit-box-shadow: 3px 3px 1px -2px rgba(1, 0, 154, 0.75);
  -moz-box-shadow: 3px 3px 1px -2px rgba(1, 0, 154, 0.75);
  margin-right: auto;
  margin-left: auto;
}
.LoginContainer {
  padding-top: 8%;
  min-height: 100vh;
}
.RowContainer {
  background-color: "transparent" !important;
}
.LoginCardContainer {
  background-color: transparent !important;
  margin-right: auto;
  margin-left: auto;
  padding-right: 5%;
  padding-left: 5%;
}

@media (max-width: 500px) {
  .RegisterCard {
    width: 100%;
  }
}
@media (max-width: 1150px) {
  .LoginCardContainer {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
  }
}
@media (max-width: 950px) {
  .LoginCardContainer {
    -ms-flex: 0 0 60%;
    flex: 0 0 60%;
    max-width: 60%;
  }
}
@media (max-width: 768px) {
  .LoginCardContainer {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>
