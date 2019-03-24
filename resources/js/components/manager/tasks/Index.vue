<template>
  <v-container>
    <v-flex sm12 xs12>
      <v-toolbar color="indigo darken-1" dark>
        <v-toolbar-title>Wszystkie zadania</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card>
        <v-card-text>
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
          <div>
            <v-data-table
              :expand="expand"
              :headers="headers"
              :items="tasks"
              :loading="isLoading"
              :pagination.sync="pagination"
              :search="search"
              class="elevation-1"
              item-key="id"
            >
              <template v-slot:items="props">
                <tr :class="isAcceptedByAll(props.item) ? colorOk : ''"
                    @click="props.expanded = !props.expanded">
                  <td>{{ props.item.id }}</td>
                  <td><b>{{ props.item.title }}</b></td>
                  <td class="text-xs-right">
                    {{ formatDate(props.item.updated_at) }}
                  </td>
                  <td class="text-xs-right">
                    {{ props.item.users_accepted_count }}/
                    {{ props.item.users_count }}
                    <v-icon
                      color="green"
                      v-if="isAcceptedByAll(props.item)"
                    >done
                    </v-icon>
                  </td>
                </tr>
              </template>
              <template v-slot:expand="props">
                <v-card flat>
                  <v-card-title><b>Opis</b></v-card-title>

                  <v-card-text>{{ props.item.body }}</v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="moreInfo(props.item.id)" color="success" dark
                           small>
                      Pokaż szczegóły
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </template>
              <v-alert :value="true" color="error" icon="warning" v-slot:no-results>
                Nie znaleziono wyników dla "{{ search }}".
              </v-alert>
            </v-data-table>
          </div>
        </v-card-text>
      </v-card>
    </v-flex>

    <v-flex class="mt-5 mb-5" sm12 v-if="showMoreInfo" xs12>
      <v-toolbar color="indigo darken-1" dark>
        <v-toolbar-title>{{ taskInfo.title }}</v-toolbar-title>
        <v-spacer></v-spacer>
        Zad. nr: {{ taskInfo.id }}
      </v-toolbar>
      <v-card>
        <v-card-text>
          <show-users-in-task-info :users="taskInfo.users"></show-users-in-task-info>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-container>
</template>

<script>
  import ShowUsersInTaskInfo from "../users/ShowUsersInTaskInfo";

  export default {
    components: {ShowUsersInTaskInfo},
    data() {
      return {
        isLoading: true,
        colorOk: 'green--text text--darken-1',
        showMoreInfo: false,
        taskInfo: {},
        tasks: [],
        pagination: {'sortBy': 'id', 'descending': true},
        selected: [],
        search: '',
        expand: false,
        headers: [
          {text: 'Nr', align: 'left', value: 'id'},
          {text: 'Nazwa zadania', align: 'left', value: 'title'},
          {text: 'Nadano', sortable: false, align: 'right', value: 'updated_at'},
          {text: 'Zatwierdziło osób', align: 'right', value: 'users_accepted_count'},
        ],
      }
    },
    created() {
      this.getTasks();
    },
    computed: {
      pages() {
        if (this.pagination.rowsPerPage == null || this.pagination.totalItems == null) {
          return 0;
        }

        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
      },
    },
    methods: {
      getTasks() {
        axios.get('/api/tasks')
          .then(res => {
            this.tasks = res.data;
            this.isLoading = false;
          })
          .catch(() => console.log('Błąd połączenia z bazą danych'))
      },
      moreInfo(task_id) {
        axios.get(`/api/task-user/${task_id}/users`)
          .then(res => {
            this.showMoreInfo = true;
            this.taskInfo = res.data;
          })
          .catch(() => console.log('Nie można wykonać akcji'))
      },
      formatDate(datetime) {
        // TODO extract global helper function
        let date = new Date(Date.parse(datetime));
        let Y = date.getFullYear();
        let M = date.getMonth() + 1;
        let D = date.getDate();
        let h = date.getHours();
        let m = date.getMinutes();
        let s = date.getSeconds();

        if (M < 10) {
          M = '0' + M;
        }
        if (s < 10) {
          s = '0' + s;
        }

        return `${Y}-${M}-${D} ${h}:${m}:${s}`;
      },
      isAcceptedByAll(task) {
        return task.users_accepted_count >= task.users_count;
      }
    },
  }
</script>
