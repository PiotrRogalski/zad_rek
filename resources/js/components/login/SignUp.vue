<template>
  <v-container>
    <form @submit.prevent="signup">
      <v-text-field
        label="Imię"
        type="text"
        v-model="form.name"
      ></v-text-field>
      <span class="red--text" v-if="errors.name">
        {{ errors.name[0] }}
      </span>

      <v-text-field
        label="Adres e-mail"
        type="email"
        v-model="form.email"
      ></v-text-field>
      <span class="red--text" v-if="errors.email">
        {{ errors.email[0] }}
      </span>

      <v-text-field
        label="Hasło"
        type="password"
        v-model="form.password"
      ></v-text-field>
      <span class="red--text" v-if="errors.password">
        {{ errors.password[0] }}
      </span>

      <v-text-field
        label="Potwierdź hasło"
        type="password"
        v-model="form.password_confirmation"
      ></v-text-field>

      <v-btn
        color="green"
        type="submit"
      >Zarejestruj
      </v-btn>

      <router-link to="/login">
        <v-btn color="blue">Zaloguj</v-btn>
      </router-link>

    </form>
  </v-container>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          name: null,
          email: null,
          password: null,
          password_confirmation: null
        },
        errors: {},
      }
    },

    created() {
      if (User.isLogged()) {
        this.$router.push({name: 'home'});
      }
    },

    methods: {
      signup() {
        this.errors = {};
        axios.post('/api/auth/signup', this.form)
          .then(res => {
            User.handleLoginResponse(res);
            this.$router.push({name: 'home'});
          })
          .catch(error => this.errors = error.response.data.errors);
      }
    }
  }
</script>
