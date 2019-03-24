<template>
  <v-container>
    <v-toolbar color="indigo darken-1" dark>
      <v-toolbar-title>Krok 1. Wybierz pracowników</v-toolbar-title>
      <v-spacer></v-spacer>
    </v-toolbar>

    <v-card>
      <v-flex sm12 xs12>
        <v-card-title>
          <v-spacer></v-spacer>
          <v-text-field
            append-icon="search"
            hide-details
            label="Szukaj"
            single-line
            v-model="search"
          ></v-text-field>
        </v-card-title>
        <v-card-text>
          <v-data-table
            :headers="headers"
            :items="users"
            :loading="isLoading"
            :pagination.sync="pagination"
            :search="search"
            class="elevation-1"
            item-key="name"
            select-all
            v-model="selected"
          >
            <template v-slot:headers="props">
              <tr>
                <th>
                  <v-checkbox
                    :indeterminate="props.indeterminate"
                    :input-value="props.all"
                    @click.stop="toggleAll"
                    hide-details
                    primary
                  ></v-checkbox>
                </th>
                <th
                  :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                  :key="header.text"
                  @click="changeSort(header.value)"
                  v-for="header in props.headers"
                >
                  <v-icon small>arrow_upward</v-icon>
                  {{ header.text }}
                </th>
              </tr>
            </template>
            <template v-slot:items="props">
              <tr :active="props.selected" @click="props.selected = !props.selected">
                <td>
                  <v-checkbox
                    :input-value="props.selected"
                    hide-details
                    primary
                  ></v-checkbox>
                </td>
                <td>
                  {{ (props.item.name == null) ? 'Nazwisko: ' : props.item.name + ' ' }}
                  {{ (props.item.surname == null) ? '' : props.item.surname }}
                </td>
                <td class="text-xs-right">
                  {{ (props.item.group == null) ? 'Brak' : props.item.group.name}}
                </td>
                <td class="text-xs-right">
                  {{ (props.item.position == null) ? 'Brak' : props.item.position.name}}
                </td>
                <td class="text-xs-right">
                  {{ (props.item.permission == null) ? 'Brak' : props.item.permission.name}}
                </td>
              </tr>
            </template>
          </v-data-table>

        </v-card-text>
      </v-flex>
    </v-card>
  </v-container>
</template>

<script>
  export default {
    data: () => ({
      search: '',
      form: {},
      users: [],
      isLoading: true,
      task: {
        isSending: false,
        successSend: false,
        errorSend: false,
      },
      pagination: {
        sortBy: 'name'
      },
      selected: [],
      headers: [
        {
          text: 'Imię i Nazwisko',
          align: 'left',
          value: 'name'
        },
        {text: 'Grupa', align: 'right', value: 'group_id'},
        {text: 'Stanowisko', align: 'right', value: 'position_id'},
        {text: 'Uprawnienia', align: 'right', value: 'permission_id'},
      ],
    }),
    created() {
      this.getUsers();
      this.listen();
    },
    methods: {
      listen() {
        EventBus.$on('sendTask', (form) => {
          this.form = form;
          this.sendTask();
        })
      },
      sendTask() {
        if (this.selected.length < 1) {
          EventBus.$emit('showCreateNewTaskError', 'Musisz wybrać pracownika/pracowników');
        } else {
          if (this.isValid(this.form)) {
            axios.post('/api/tasks', {task: this.form, users: this.selected})
              .then(res => {
                EventBus.$emit('showCreateNewTaskSuccess', 'Wysłano!');
                this.selected = [];
              })
              .catch(error => {
                EventBus.$emit('showCreateNewTaskError', 'Błąd podczas wysłania');
              })
          }
        }
      },
      isValid(obj) {
        return (typeof obj == 'object');
      },
      getUsers() {
        axios.get('/api/users')
          .then(res => {
            this.users = res.data;
            this.isLoading = false;
          })
          .catch(error => {
            EventBus.$emit('showCreateNewTaskError', 'Brak połączenia z bazą danych');
          })
      },

      toggleAll() {
        if (this.selected.length) this.selected = [];
        else this.selected = this.users.slice()
      },
      changeSort(column) {
        if (this.pagination.sortBy === column) {
          this.pagination.descending = !this.pagination.descending
        } else {
          this.pagination.sortBy = column;
          this.pagination.descending = false
        }
      }
    }
  }
</script>
