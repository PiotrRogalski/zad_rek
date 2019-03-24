<template>
  <div>
    <v-toolbar>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"
                           class="hidden-md-and-up"></v-toolbar-side-icon>
      <v-toolbar-title v-if="!isLogged">Zadanie Rekrutacyjne</v-toolbar-title>
      <v-toolbar-title class="mr-3">{{user.name + ' ' + user.surname}}</v-toolbar-title>
      <b class="blue-grey--text text--darken-3" v-if="isManager">Menadżer</b>
      <b class="blue-grey--text text--darken-3" v-if="isWorker">Pracownik</b>

      <v-spacer></v-spacer>

      <div>
        <div class="hidden-sm-and-down">
          <router-link
            :key="button.text"
            :to="button.to"
            v-for="button in navbarButtons"
            v-if="button.show">
            <v-btn flat>{{ button.text }}</v-btn>
          </router-link>
        </div>
      </div>
    </v-toolbar>

    <v-navigation-drawer
      absolute
      class="pa-4"
      id="drawer"
      temporary
      v-model="drawer"
      width="200">
      <h4>Wybierz akcję</h4>
      <router-link
        :key="button.text"
        :to="button.to"
        flat
        v-for="button in navbarButtons"
        v-if="button.show">
        <v-btn flat>{{ button.text }}</v-btn>
      </router-link>
    </v-navigation-drawer>
  </div>
</template>

<script>

  export default {
    data() {
      return {
        user: {
          name: '',
          surname: '',
        },
        isLogged: User.isLogged(),
        isManager: User.isManager(),
        isWorker: User.isWorker(),
        drawer: null,
        navbarButtons: [
          {text: 'Strona główna', to: '/', show: true},
          {text: 'Nowe zadanie', to: '/new-task', show: User.isManager()},
          {text: 'Wszystkie zadania', to: '/all-tasks', show: User.isManager()},
          {text: 'Moje zadania', to: '/my-tasks', show: User.isWorker()},
          {text: 'Wyloguj', to: '/logout', show: User.isLogged()},
          {text: 'Zaloguj', to: '/login', show: !User.isLogged()},
        ],

      }
    },
    created() {
      EventBus.$on('logout', () => {
        User.logout();
      });
      if (this.isLogged) {
        axios.post('/api/auth/me')
          .then(res => this.user = res.data)
          .catch(error => console.log(error.response.data))
      }
    },
  }
</script>
