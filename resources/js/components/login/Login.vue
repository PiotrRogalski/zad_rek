<template>
  <v-container>
    <v-layout>
      <v-flex offset-sm3 sm6 xs12>
        <v-card>
          <v-card-title primary-title>
            <div>
              <h3 class="headline mb-0">Zaloguj się do aplikacji</h3>
            </div>
          </v-card-title>
          <v-card-text>
            <div>
              <v-form @submit.prevent="login">
                <v-text-field
                  label="E-mail"
                  required
                  type="email"
                  v-model="form.email"
                ></v-text-field>

                <v-text-field
                  label="Hasło"
                  required
                  type="password"
                  v-model="form.password"
                ></v-text-field>

                <v-btn
                  color="green"
                  dark
                  type="submit"
                >Zaloguj
                </v-btn>

                <v-btn
                  @click="setWorker"
                  color="teal"
                  dark
                >Pracownik
                </v-btn>

                <v-btn
                  @click="setManager"
                  color="indigo"
                  dark
                >Menadżer
                </v-btn>
              </v-form>
            </div>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          email: null,
          password: null
        },
      }
    },

    created() {
      if (User.isLogged()) {
        this.$router.push({name: 'home'});
      }
    },

    methods: {
      login() {
        window.User.login(this.form);
      },
      setWorker() {
        this.form.email = 'pracownik@gmail.com';
        this.form.password = 'password';
      },
      setManager() {
        this.form.email = 'menadzer@gmail.com';
        this.form.password = 'password';
      },
    }
  }
</script>
